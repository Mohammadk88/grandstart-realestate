<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Session::has('admin_id')) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $admin = Admin::where('email', $request->email)->where('active', true)->first();

        if (!$admin || !$admin->verifyPassword($request->password)) {
            return back()->withErrors(['email' => __('app.invalid_credentials')])->withInput();
        }

        Session::put('admin_id', $admin->id);
        Session::put('admin_name', $admin->name);
        Session::put('admin_email', $admin->email);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Session::forget(['admin_id', 'admin_name', 'admin_email']);
        return redirect()->route('admin.login');
    }
}
