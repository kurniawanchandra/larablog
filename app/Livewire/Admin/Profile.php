<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Helpers\Cmail;
use App\Models\UserSocialLink;

class Profile extends Component
{
    public $tab = null;
    public $tabname = 'personal_detail';
    protected $queryString = ['tab' => ['keep' => true]];
    public $name, $email, $username, $bio;
    public $current_password;
    public $new_password;
    public $new_password_confirmation;
    public $instagram_url, $facebook_url, $youtube_url, $linkedin_url, $github_url, $twitter_url;

    /**
     * selectTab
     *
     * @param  mixed $tab
     * @return void
     */
    public function selectTab($tab)
    {
        $this->tab = $tab;
    }

    /**
     * mount
     *
     * @return void
     */
    public function mount()
    {
        $this->tab = Request('tab') ? Request('tab') : $this->tabname;
        //populate
        $user = User::with('social_links')->findOrFail(auth()->id());
        // dd($user);
        $this->name = $user->name;
        $this->email = $user->email;
        $this->username = $user->username;
        $this->bio = $user->bio;

        //populate social links
        if (!is_null($user->social_links)) {
            $this->facebook_url = $user->social_links->facebook_url;
            $this->instagram_url = $user->social_links->instagram_url;
            $this->youtube_url = $user->social_links->youtube_url;
            $this->linkedin_url = $user->social_links->linkedin_url;
            $this->github_url = $user->social_links->github_url;
            $this->twitter_url = $user->social_links->twitter_url;
        }
    }

    public function updatePersonalDetails()
    {
        $user = User::findOrFail(auth()->id());
        // $this->validate([
        //     'name' => 'required',
        //     'username' => 'required|unique:users,username,'.$user->id,
        // ]);

        $this->validate([
            'name' => 'required',
            'username' => 'required|regex:/^\S*$/|unique:users,username,' . $user->id,
        ], [
            'username.regex' => 'Username tidak boleh mengandung spasi.',
        ]);

        //update user info
        $user->name = $this->name;
        $user->username = $this->username;
        $user->bio = $this->bio;
        $updated = $user->save();

        sleep(0.5);
        if ($updated) {
            $this->dispatch('showToastr', ['type' => 'success', 'message' => 'Profile updated successfully']);
            $this->dispatch('updateTopUserInfo')->to(TopUserInfo::class);
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Failed to update profile']);
        }
    }

    public function updatePassword()
    {
        //dd('Update Password....');
        $user = User::findOrFail(auth()->id());
        //validate form
        $this->validate([
            'current_password' => [
                'required',
                'min:5',
                function ($attribute, $value, $fail) use ($user) {
                    if (!Hash::check($value, $user->password)) {
                        return $fail(__('Your current password does not match our records. '));
                    }
                }
            ],
            'new_password' => 'required|min:5|confirmed'
        ]);
        //update password   
        $updated = $user->update([
            'password' => Hash::make($this->new_password)
        ]);

        if ($updated) {
            $data = [
                'user' => $user,
                'new_password' => $this->new_password
            ];

            $mail_body = view('email-templates.password-changes-template', $data)->render();

            $mail_config = [
                'recipient_address' => $user->email,
                'recipient_name' => $user->name,
                'subject' => 'Password Changed',
                'body' => $mail_body,
            ];

            Cmail::send($mail_config);
            auth()->logout();
            Session::flash('info', 'Your Password has been succesfully change, please log in');
            $this->redirectRoute('admin.login');
        } else {
            $this->dispatch('showToastr', ['type' => 'error', 'message' => 'Something went wrong']);
        }
    }

    /**
     * updateSocialLinks
     *
     * @return void
     */
    public function updateSocialLinks()
    {
        $this->validate([
            'facebook_url' => 'nullable|url',
            'instagram_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'youtube_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'github_url' => 'nullable|url',
        ]);
        $user = User::findOrFail(auth()->id());

        $data = array(
            'facebook_url' => $this->facebook_url,
            'instagram_url' => $this->instagram_url,
            'twitter_url' => $this->twitter_url,
            'youtube_url' => $this->youtube_url,
            'linkedin_url' => $this->linkedin_url,
            'github_url' => $this->github_url,
        );

       if(!is_null($user->social_links)){
            //update records
            $query = $user->social_links()->update($data);
       }else{
            //insert new data
            $data['user_id']=$user->id;
            $query = $user->social_links()->insert($data);
       }

       if($query){
            $this->dispatch('showToastr', ['type'=> 'success','message'=>'Your Social have been updated successfully']);
       }else{
            $this->dispatch('showToastr', ['type'=> 'error','message'=>'Something when wrong']);
       }
    }

    
    public function render()
    {
        return view('livewire.admin.profile', [
            'user' => User::findOrFail(auth()->id())
        ]);
    }
}
