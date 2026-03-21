<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $table = 'activity_log';

    protected $fillable = [
        'log_name',
        'description',
        'comment',
        'sent_email',
        'subject_type',
        'event',
        'subject_id',
        'causer_type',
        'causer_id',
        'properties',
        'batch_uuid',
    ];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the causer (morph relationship).
     */
    public function causer()
    {
        return $this->morphTo();
    }

    /**
     * Get the subject (morph relationship).
     */
    public function subject()
    {
        return $this->morphTo();
    }
}
