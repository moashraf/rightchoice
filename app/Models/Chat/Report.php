<?php

namespace App\Models\Chat;

use MongoDB\Laravel\Eloquent\Model;

class Report extends Model
{
    protected $connection = 'mongodb';
    protected $collection = 'reports';

    protected $fillable = [
        'reporter_id',
        'reported_id',
        'reported_type',
        'reported_content_id',
        'reason',
        'details',
        'status',
        'admin_notes',
        'reviewed_by',
        'reviewed_at',
    ];

    protected $casts = [
        'reporter_id' => 'integer',
        'reported_id' => 'integer',
        'reviewed_by' => 'integer',
    ];

    protected $attributes = [
        'status' => 'pending',
    ];

    // ── Scopes ───────────────────────────────────────────────────

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // ── Helpers ──────────────────────────────────────────────────

    public function getReporter()
    {
        return \App\Models\User::find($this->reporter_id);
    }

    public function getReportedUser()
    {
        return \App\Models\User::find($this->reported_id);
    }

    public function getReviewer()
    {
        return $this->reviewed_by ? \App\Models\User::find($this->reviewed_by) : null;
    }

    public function getStatusLabel(): string
    {
        return match ($this->status) {
            'pending' => 'قيد المراجعة',
            'reviewed' => 'تمت المراجعة',
            'resolved' => 'تم الحل',
            'dismissed' => 'مرفوض',
            default => $this->status,
        };
    }

    public function getStatusBadge(): string
    {
        return match ($this->status) {
            'pending' => 'warning',
            'reviewed' => 'info',
            'resolved' => 'success',
            'dismissed' => 'secondary',
            default => 'light',
        };
    }
}
