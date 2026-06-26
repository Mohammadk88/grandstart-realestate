<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    const ROLE_SUPER_ADMIN  = 'super_admin';
    const ROLE_MANAGER      = 'manager';
    const ROLE_DATA_ENTRY   = 'data_entry';
    const ROLE_CALL_CENTER  = 'call_center';

    const ROLES = [
        self::ROLE_SUPER_ADMIN => 'مدير عام',
        self::ROLE_MANAGER     => 'مدير',
        self::ROLE_DATA_ENTRY  => 'مدخل بيانات',
        self::ROLE_CALL_CENTER => 'كول سنتر',
    ];

    const ROLE_PERMISSIONS = [
        self::ROLE_SUPER_ADMIN => ['*'],
        self::ROLE_MANAGER => [
            'dashboard',
            'projects.view', 'projects.create', 'projects.edit', 'projects.delete',
            'contacts.view', 'contacts.edit', 'contacts.delete',
            'pages.manage', 'hero.manage', 'page_builder.manage', 'countries.manage',
        ],
        self::ROLE_DATA_ENTRY => [
            'dashboard',
            'projects.view', 'projects.create', 'projects.edit',
            'pages.manage', 'hero.manage', 'page_builder.manage',
        ],
        self::ROLE_CALL_CENTER => [
            'dashboard',
            'contacts.view', 'contacts.edit',
            'projects.view',
        ],
    ];

    const ROLE_COLORS = [
        self::ROLE_SUPER_ADMIN => '#C9A84C',
        self::ROLE_MANAGER     => '#3b82f6',
        self::ROLE_DATA_ENTRY  => '#10b981',
        self::ROLE_CALL_CENTER => '#8b5cf6',
    ];

    protected $fillable = [
        'name', 'email', 'phone', 'password', 'active', 'role',
        'last_login_at',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'active'        => 'boolean',
        'last_login_at' => 'datetime',
    ];

    public function assignedContacts(): HasMany
    {
        return $this->hasMany(Contact::class, 'assigned_to');
    }

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function hasPermission(string $permission): bool
    {
        $permissions = self::ROLE_PERMISSIONS[$this->role] ?? [];

        if (in_array('*', $permissions)) {
            return true;
        }

        return in_array($permission, $permissions);
    }

    public function isSuperAdmin(): bool
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function getRoleLabel(): string
    {
        return self::ROLES[$this->role] ?? $this->role;
    }

    public function getRoleColor(): string
    {
        return self::ROLE_COLORS[$this->role] ?? '#aaa';
    }

    public static function allActive()
    {
        return self::where('active', true)->orderBy('name')->get();
    }
}
