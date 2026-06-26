<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = Admin::orderBy('role')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:admins,email',
            'phone'    => 'nullable|string|max:30',
            'role'     => ['required', Rule::in(array_keys(Admin::ROLES))],
            'password' => 'required|string|min:8|confirmed',
            'active'   => 'boolean',
        ]);

        Admin::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم إضافة المستخدم بنجاح');
    }

    public function edit(Admin $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, Admin $user)
    {
        $currentAdmin = app('currentAdmin');

        // Prevent demoting the only super admin
        if ($user->isSuperAdmin() && $request->role !== Admin::ROLE_SUPER_ADMIN) {
            $otherSuperAdmins = Admin::where('role', Admin::ROLE_SUPER_ADMIN)
                ->where('id', '!=', $user->id)->count();
            if ($otherSuperAdmins === 0) {
                return back()->with('error', 'لا يمكن تغيير دور المدير العام الوحيد في النظام.');
            }
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => ['required', 'email', Rule::unique('admins')->ignore($user->id)],
            'phone'    => 'nullable|string|max:30',
            'role'     => ['required', Rule::in(array_keys(Admin::ROLES))],
            'password' => 'nullable|string|min:8|confirmed',
            'active'   => 'boolean',
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $validated['active'] = $request->boolean('active');

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'تم تحديث بيانات المستخدم بنجاح');
    }

    public function destroy(Admin $user)
    {
        $currentAdmin = app('currentAdmin');

        if ($user->id === $currentAdmin->id) {
            return back()->with('error', 'لا يمكنك حذف حسابك الخاص.');
        }

        if ($user->isSuperAdmin()) {
            $count = Admin::where('role', Admin::ROLE_SUPER_ADMIN)->count();
            if ($count <= 1) {
                return back()->with('error', 'لا يمكن حذف المدير العام الوحيد.');
            }
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'تم حذف المستخدم بنجاح');
    }

    public function toggleActive(Admin $user)
    {
        $currentAdmin = app('currentAdmin');

        if ($user->id === $currentAdmin->id) {
            return response()->json(['error' => 'لا يمكنك تعطيل حسابك الخاص.'], 422);
        }

        $user->update(['active' => !$user->active]);

        return response()->json(['success' => true, 'active' => $user->active]);
    }
}
