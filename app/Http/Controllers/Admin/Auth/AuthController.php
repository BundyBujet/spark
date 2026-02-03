<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function get_admin_login()
    {
        return view('admin.auth.login');
    }
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|exists:admins,username|max:50',
            'password' => 'required|max:50',

        ]);


        if (auth()->guard('admin')->attempt(['username' => $request->username, 'password' => $request->password])) {


            $message = trans('AUTH_SUCCESS');
            $notification = array(
                'message' => $message,
                'type' => 'success',
                'duration' => 4000
            );

            return redirect()->route('admin.dashboard')->with($notification);
        } else {

            $message = trans('AUTH_ERROR');
            $notification = array(
                'message' => $message,
                'type' => 'danger',
                'duration' => 4000
            );

            return redirect()->back()->with($notification);
        }
    }

    public function logout()
    {
        auth()->guard('admin')->logout();
        session()->invalidate();
        $message = trans('AUTH_LOGOUT_SUCCESS');
        $notification = array(
            'message' => $message,
            'type' => 'success',
            'duration' => 4000
        );
        return redirect()->route('get.admin.login')->with($notification);
    }
}
