<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use SawaStacks\Utils\Kropify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\GeneralSetting;

class AdminController extends Controller
{
    /**
     * adminDashboard
     *
     * @param  mixed $request
     * @return void
     */
    public function adminDashboard(Request $request)
    {
        $data = [
            'pageTitle' => 'Dashboard'
        ];
        return view('back.pages.dashboard', $data);
    }

    public function logoutHandler(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login')->with('fail', 'You are now logged out !!');
    }

    public function profileView(Request $request)
    {
        $data = [
            'pageTitle' => 'Profile'
        ];
        return view('back.pages.profile', $data);
    }

    public function updateProfilePicture(Request $request)
    {
        $user = User::findOrFail(auth()->id());
        $path = 'images/users';
        //dd($path);
        $file = $request->file('profilePictureFile');
        $old_picture = $user->getAttributes()['picture'];
        $filename = 'IMG_' . uniqid() . '.png';
        //dd($old_picture);
        $upload = Kropify::getFile($file, $filename)->setPath($path)->useMove()->save();
        // dd([
        //     'upload_result' => $upload,
        //     'saved_path' => $path . '/' . $filename,
        //     'file_exists' => File::exists(public_path($path . '/' . $filename)),
        // ]);
        //dd($upload);
        if ($upload) {
            if ($old_picture != null && File::exists(public_path($path . $old_picture))) {
                File::delete(public_path($path . $old_picture));
            }
            //update profile
            $user->update(['picture' => $filename]);

            // dd([
            //     'message' => 'Profile picture updated',
            //     'new_picture' => $filename,
            //     'full_path' => public_path($path . '/' . $filename),
            //     'file_exists' => File::exists(public_path($path . '/' . $filename)),
            //     'user_picture_column' => $user->fresh()->picture,
            // ]);
            return response()->json(['status' => 1, 'message' => 'Your profile picture has been updated successfully']);
        } else {
            return response()->json(['status' => 0, 'message' => 'Something went wrong']);
        }
    }
    //end method

    public function generalSettings(Request $request)
    {
        $data = [
            'pageTitle' => 'General Settings'
        ];
        return view('back.pages.general_settings', $data);
    }
    //end method
    public function updateLogo(Request $request)
    {
        $settings = GeneralSetting::take(1)->first();
        if (!is_null($settings)) {
            $path = 'images/site';
            $old_logo = $settings->site_logo;
            $file = $request->file('site_logo');
            $filename = 'logo_' . uniqid() . '.png';

            if ($request->hasFile('site_logo')) {
                $upload = $file->move(public_path($path), $filename);
                if ($upload) {
                    if ($old_logo != null && File::exists(public_path($path . $old_logo))) {
                        File::delete(public_path($path . $old_logo));
                    }
                    $settings->update(['site_logo' => $filename]);

                    return response()->json(['status' => 1, 'image_path' => $path . $filename, 'message' => 'Site logo has been updated successfully']);
                } else {
                    return response()->json(['status' => 0, 'message' => 'Something when wrong in uploading new logo']);
                }
            } else {
                return response()->json(['status' => 0, 'message' => 'Make sure you updated general settings from first']);
            }
        }
    }
    //end method

    public function updateFavicon(Request $request)
    {
        $settings = GeneralSetting::take(1)->first();

        if (!is_null($settings)) {
            $path = 'images/site/';
            $old_favicon = $settings->site_favicon;
            $file = $request->file('site_favicon');
            $filename = 'favicon_' . uniqid() . '.png';

            if ($request->hasFile('site_favicon')) {
                $upload = $file->move(public_path($path), $filename);
                if ($upload) {
                    if ($old_favicon != null && File::exists(public_path($path . $old_favicon))) {
                        File::delete(public_path($path . $old_favicon));
                    }

                    $settings->update(['site_favicon' => $filename]);
                    return response()->json(['status' => 1, 'message' => 'Site favicon has been updated succesfully', 'image_path' => $path . $filename]);
                } else {
                    return response()->json(['status' => 0, 'message' => 'Something when wrong in uploading new favicon']);
                }
            }
        } else {
            return response()->json(['status' => 0, 'message' => 'Make sure you updated general settings tab first']);
        }
    }
    //end method

    public function categoriesPage(Request $request)
    {
        $data = [
            'pageTitle' => 'Manage Categories'
        ];

        return view('back.pages.categories_page', $data);
    }
}
