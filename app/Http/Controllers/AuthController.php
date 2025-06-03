<?php

namespace App\Http\Controllers;

use App\UserType;
use App\UserStatus;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Helpers\Cmail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use function Ramsey\Uuid\v1;

class AuthController extends Controller
{
    public function loginForm(Request $request)
    {
        $data = [
            'pageTitle' => 'Login'
        ];
        return view('back.pages.auth.login', $data);
    }

    public function forgotForm(Request $request)
    {
        $data = [
            'pageTitle' => 'Forgot Password'
        ];
        return view('back.pages.auth.forgot', $data);
    }

    public function loginHandler(Request $request)
    {
        //dd($request->all());
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        // dd($fieldType);
        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5'
            ], [
                'login_id.exists' => 'Email or username not found',
                'login_id.email' => 'Invalid email',
                'login_id.required' => 'Email or username is required',
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:users,username',
                'password' => 'required|min:5'
            ], [
                'login_id.required' => 'Enter your username or email',
                'login_id.exists' => 'Username or email not found',
            ]);
        }

        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password,
        );

        if (Auth::attempt($creds)) {
            //check if account is inactive
            if (auth()->user()->status == UserStatus::Inactive) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'Your Account is currently inactive, 
                please contact the admin to activate your account');
            }
            //check if account is in Pending mode
            if (auth()->user()->status == UserStatus::Pending) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('admin.login')->with('fail', 'Your Account is currently Pending Approval, 
                please contact the admin to activate your account');
            }
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->withInput()->with('fail', 'incorrect password.');
        }
    } //end method

    public function sendPasswordResetLink(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ], [
            'email.required' => 'Email is required',
            'email.email' =>  'Invalid Email addreess',
            'email.exists' => 'Email not found',
        ]);

        //get users details
        $user = User::where('email', $request->email)->first();
        // dd($user);
        //Generate token
        $token = base64_encode(Str::random(64));
        //check if there isa an existing token
        $oldToken = DB::table('password_reset_tokens')
            ->where('email', $user->email)
            ->first();
        if ($oldToken) {
            DB::table('password_reset_tokens')
                ->where('email', $user->email)
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else {
            DB::table('password_reset_tokens')->insert([
                'email' => $user->email,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        //create clickable action link
        $actionLink = route('admin.reset_password_form', ['token' => $token]);
        $data = array(
            'actionLink' => $actionLink,
            'user' => $user
        );
        $mail_body = view('email-templates.forgot-template', $data)->render();
        // dd($mail_body);
        $mailConfig = array(
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Reset Password',
            'body' => $mail_body,
        );
        //    var_dump($mailConfig);

        //$result = Cmail::send($mailConfig);
        //dd($result);
        if (Cmail::send($mailConfig)) {
            return redirect()->route('admin.forgot')->with('success', 'We have e-mailed your password reset link.');
        } else {
            return redirect()->route('admin.forgot')->with('fail', 'Something went wrong, Resetting password link not send. Try again later');
        }
    }
    //end method
    public function resetForm(Request $request, $token = null)
    {
        //dd($token);
        //check if token is valid
        $isTokenExists = DB::table('password_reset_tokens')
            ->where('token', $token)
            ->first();
        if (!$isTokenExists) {
            return redirect()->route('admin.forgot')
                ->with('fail', 'Invalid token, request another reset password link');
        } else {
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s',$isTokenExists->created_at)
                        ->diffInMinutes(Carbon::now());
            if($diffMins > 15){
                return redirect()->route('admin.forgot')->with('fail','The password reset link you clicked has expired. Please request a new link');
            }
            $data = [
                'pageTitle' => 'Reset Password',
                'token' => $token,
            ];

            return view('back.pages.auth.reset', $data);
        }
    } //end method


    /**
     * resetPasswordHandler
     *
     * @param  mixed $request
     * @return void
     */
    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:5|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required',
        ]);

        $dbToken = DB::table('password_reset_tokens')->first();
            
        //dd($dbToken);
        $user = User::where('email',$dbToken->email)->first();
        //dd($user);
        //update password
        User::where('email', $user->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        //send notification to email to this user email that contains new password
        $data = [
            'user' => $user,
            'new_password' => $request->new_password
        ];

        $mail_body = view('email-templates.password-changes-template', $data)->render();
        $mailConfig = [
            'recipient_address' => $user->email,
            'recipient_name' => $user->name,
            'subject' => 'Password Changed',
            'body' => $mail_body,
        ];

        if (Cmail::send($mailConfig)) {
            DB::table('password_reset_tokens')->where([
                'email' => $dbToken->email,
                'token' => $dbToken->token
            ])->delete();

            return redirect()->route('admin.login')->with('success', 'Done! Your password has been changed successfully. Use your new password to login into system');
        } else {
            return redirect()->route('admin.reset_password_form', ['token' => $dbToken->token])->with('fail', 'Something when wrong. Try again later');
        }
    }
}
