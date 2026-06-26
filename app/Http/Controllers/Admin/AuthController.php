<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;

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
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $key = 'admin-login:' . $request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            throw ValidationException::withMessages([
                'email' => __('app.too_many_attempts', ['seconds' => $seconds]),
            ]);
        }

        $admin = Admin::where('email', $request->email)->where('active', true)->first();

        if (!$admin || !$admin->verifyPassword($request->password)) {
            RateLimiter::hit($key, 60);
            return back()->withErrors(['email' => __('app.invalid_credentials')])->withInput();
        }

        RateLimiter::clear($key);

        $admin->update(['last_login_at' => now()]);

        Session::regenerate();
        Session::put('admin_id', $admin->id);
        Session::put('admin_name', $admin->name);
        Session::put('admin_email', $admin->email);
        Session::put('admin_role', $admin->role);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        Session::flush();
        Session::regenerate();
        return redirect()->route('admin.login');
    }
}
