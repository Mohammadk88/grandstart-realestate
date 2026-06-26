<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Admin extends Model
{
    protected $fillable = ['name', 'email', 'password', 'active'];

    protected $hidden = ['password'];

    protected $casts = ['active' => 'boolean'];

    public function verifyPassword(string $password): bool
    {
        return Hash::check($password, $this->password);
    }

    public function setPasswordAttribute(string $value): void
    {
        $this->attributes['password'] = Hash::make($value);
    }
}
