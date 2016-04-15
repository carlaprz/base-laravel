<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Session;

class UserController extends Controller
{

    public function index()
    {
        return View('front.statics.login');
    }

    public function login( Request $request )
    {
        $this->validate($request, [
            'email' => 'required|email', 'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password'], 'status' => 1, 'rol' => 2])) {
            return back();
        } else {
            return back()->withInput($request->only('email', 'remember'))
                            ->withErrors([
                                'email' => $this->getFailedLoginMessage(),
            ]);
        }
    }

    protected function getFailedLoginMessage()
    {
        return 'These credentials do not match our records.';
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        return back();
    }

}
