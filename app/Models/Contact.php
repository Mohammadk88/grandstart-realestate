<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    const STATUS_NEW         = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_CONVERTED   = 'converted';
    const STATUS_CLOSED      = 'closed';
    const STATUS_SPAM        = 'spam';

    const STATUSES = [
        self::STATUS_NEW         => ['label' => 'جديد',       'color' => '#3b82f6', 'bg' => 'rgba(59,130,246,0.12)'],
        self::STATUS_IN_PROGRESS => ['label' => 'قيد المتابعة','color' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.12)'],
        self::STATUS_CONVERTED   => ['label' => 'تم التحويل', 'color' => '#10b981', 'bg' => 'rgba(16,185,129,0.12)'],
        self::STATUS_CLOSED      => ['label' => 'مغلق',       'color' => '#6b7280', 'bg' => 'rgba(107,114,128,0.12)'],
        self::STATUS_SPAM        => ['label' => 'سبام',       'color' => '#ef4444', 'bg' => 'rgba(239,68,68,0.12)'],
    ];

    const PRIORITY_LOW    = 'low';
    const PRIORITY_MEDIUM = 'medium';
    const PRIORITY_HIGH   = 'high';
    const PRIORITY_URGENT = 'urgent';

    const PRIORITIES = [
        self::PRIORITY_LOW    => ['label' => 'منخفض', 'color' => '#6b7280', 'icon' => 'fa-arrow-down'],
        self::PRIORITY_MEDIUM => ['label' => 'متوسط', 'color' => '#f59e0b', 'icon' => 'fa-minus'],
        self::PRIORITY_HIGH   => ['label' => 'مرتفع',  'color' => '#ef4444', 'icon' => 'fa-arrow-up'],
        self::PRIORITY_URGENT => ['label' => 'عاجل',   'color' => '#dc2626', 'icon' => 'fa-fire'],
    ];

    protected $fillable = [
        'name', 'email', 'phone',
        'message', 'project_id',
        'country_code', 'source',
        'is_read', 'notes',
        'status', 'priority',
        'assigned_to', 'crm_notes',
        'follow_up_at', 'last_action_at', 'last_action_by',
    ];

    protected $casts = [
        'is_read'        => 'boolean',
        'follow_up_at'   => 'datetime',
        'last_action_at' => 'datetime',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'assigned_to');
    }

    public function lastActionAdmin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'last_action_by');
    }

    public function getStatusLabel(): string
    {
        return self::STATUSES[$this->status]['label'] ?? $this->status;
    }

    public function getStatusColor(): string
    {
        return self::STATUSES[$this->status]['color'] ?? '#aaa';
    }

    public function getStatusBg(): string
    {
        return self::STATUSES[$this->status]['bg'] ?? 'rgba(170,170,170,0.1)';
    }

    public function getPriorityLabel(): string
    {
        return self::PRIORITIES[$this->priority]['label'] ?? $this->priority;
    }

    public function getPriorityColor(): string
    {
        return self::PRIORITIES[$this->priority]['color'] ?? '#aaa';
    }

    public function getPriorityIcon(): string
    {
        return self::PRIORITIES[$this->priority]['icon'] ?? 'fa-minus';
    }

    public function isFollowUpDue(): bool
    {
        return $this->follow_up_at && $this->follow_up_at->isPast()
            && !in_array($this->status, [self::STATUS_CONVERTED, self::STATUS_CLOSED]);
    }

    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeAssignedTo($query, int $adminId)
    {
        return $query->where('assigned_to', $adminId);
    }

    public function scopeDueFollowUp($query)
    {
        return $query->whereNotNull('follow_up_at')
            ->where('follow_up_at', '<=', now())
            ->whereNotIn('status', [self::STATUS_CONVERTED, self::STATUS_CLOSED]);
    }
}
