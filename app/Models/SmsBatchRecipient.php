<?php

namespace App\Models;

use App\Enums\SmsSendStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * SmsBatchRecipient model – stores per-recipient SMS details.
 *
 * Tracks the personalized message, mobile validation result,
 * send status, provider response, and timestamps for each user in a batch.
 */
class SmsBatchRecipient extends Model
{
    protected $table = 'sms_batch_recipients';

    protected $fillable = [
        'batch_id',
        'user_id',
        'recipient_name',
        'recipient_mobile',
        'normalized_mobile',
        'personalized_message',
        'validation_status',
        'validation_reason',
        'send_status',
        'provider_message_id',
        'provider_response',
        'failure_reason',
        'sent_at',
        'delivered_at',
    ];

    protected $casts = [
        'sent_at'      => 'datetime',
        'delivered_at' => 'datetime',
    ];

    // ─── Relationships ──────────────────────────────────────────────────

    /**
     * The batch this recipient belongs to.
     */
    public function batch(): BelongsTo
    {
        return $this->belongsTo(SmsBatch::class, 'batch_id');
    }

    /**
     * The user this recipient refers to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Status change audit trail for this recipient.
     */
    public function statusLogs(): HasMany
    {
        return $this->hasMany(SmsStatusLog::class, 'batch_recipient_id');
    }

    // ─── Helpers ────────────────────────────────────────────────────────

    /**
     * Update the send status with audit logging.
     */
    public function updateStatus(string $newStatus, ?string $notes = null, ?string $providerResponse = null): void
    {
        $oldStatus = $this->send_status;

        $this->send_status = $newStatus;

        // Set sent_at timestamp when moving to 'sent'
        if ($newStatus === SmsSendStatusEnum::SENT && !$this->sent_at) {
            $this->sent_at = now();
        }

        // Set delivered_at timestamp when moving to 'delivered'
        if ($newStatus === SmsSendStatusEnum::DELIVERED && !$this->delivered_at) {
            $this->delivered_at = now();
        }

        $this->save();

        // Write audit log entry
        SmsStatusLog::create([
            'batch_recipient_id' => $this->id,
            'old_status'         => $oldStatus,
            'new_status'         => $newStatus,
            'notes'              => $notes,
            'provider_response'  => $providerResponse,
        ]);
    }

    /**
     * Get the Arabic label for the send status.
     */
    public function getSendStatusLabelAttribute(): string
    {
        return SmsSendStatusEnum::label($this->send_status);
    }

    /**
     * Get the badge CSS class for the send status.
     */
    public function getSendStatusBadgeAttribute(): string
    {
        return SmsSendStatusEnum::badgeClass($this->send_status);
    }
}
