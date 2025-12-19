<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminLoginController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (
            $request->username === env('ADMIN_USER') &&
            $request->password === env('ADMIN_PASSWORD')
        ) {
            $request->session()->put('admin_logged_in', true);
            return redirect('/overview');
        }

        return back()->withErrors([
            'login' => 'Invalid credentials'
        ]);
    }

    public function logout(Request $request)
    {
        $request->session()->forget('admin_logged_in');
        return redirect('/login');
    }
}
