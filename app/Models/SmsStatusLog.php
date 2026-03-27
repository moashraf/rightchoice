<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * SmsStatusLog model – audit trail for SMS recipient status changes.
 *
 * Records every transition (old_status → new_status) with optional notes and provider data.
 */
class SmsStatusLog extends Model
{
    protected $table = 'sms_status_logs';

    // Only created_at is used; no updated_at column
    const UPDATED_AT = null;

    protected $fillable = [
        'batch_recipient_id',
        'old_status',
        'new_status',
        'notes',
        'provider_response',
    ];

    // ─── Relationships ──────────────────────────────────────────────────

    /**
     * The recipient record this log entry belongs to.
     */
    public function recipient(): BelongsTo
    {
        return $this->belongsTo(SmsBatchRecipient::class, 'batch_recipient_id');
    }
}
