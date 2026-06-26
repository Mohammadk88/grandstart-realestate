<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminPermission
{
    public function handle(Request $request, Closure $next, string ...$permissions)
    {
        $admin = app('currentAdmin');

        foreach ($permissions as $permission) {
            if ($admin->hasPermission($permission)) {
                return $next($request);
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['error' => 'غير مصرح لك بهذا الإجراء.'], 403);
        }

        return redirect()->route('admin.dashboard')
            ->with('error', 'ليس لديك صلاحية للوصول إلى هذه الصفحة.');
    }
}
