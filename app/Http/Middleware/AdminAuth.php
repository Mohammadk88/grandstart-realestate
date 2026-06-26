<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class AdminAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('admin_id')) {
            return redirect()->route('admin.login')->with('error', __('app.please_login'));
        }

        $admin = Admin::find(Session::get('admin_id'));

        if (!$admin || !$admin->active) {
            Session::flush();
            return redirect()->route('admin.login')->with('error', 'تم تعطيل حسابك. تواصل مع المدير.');
        }

        // Make admin available to all admin views and app container
        app()->instance('currentAdmin', $admin);
        View::share('currentAdmin', $admin);

        return $next($request);
    }
}
