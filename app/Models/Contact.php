<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name', 'email', 'phone',
        'message', 'project_id',
        'country_code', 'source',
        'is_read', 'notes',
    ];

    protected $casts = [
        'is_read' => 'boolean',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }
}
