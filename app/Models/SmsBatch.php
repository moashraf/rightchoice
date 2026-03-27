<?php

namespace App\Models;

use App\Enums\SmsBatchStatusEnum;
use App\Enums\SmsSendTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * SmsBatch model – represents an SMS campaign/batch record.
 *
 * Each batch has a message template, a send type (all or selected users),
 * overall status, and aggregate counters. Related recipients are in SmsBatchRecipient.
 */
class SmsBatch extends Model
{
    protected $table = 'sms_batches';

    protected $fillable = [
        'created_by_user_id',
        'send_type',
        'message_template',
        'total_recipients',
        'total_valid_numbers',
        'total_invalid_numbers',
        'total_sent',
        'total_failed',
        'total_delivered',
        'overall_status',
        'provider_name',
    ];

    protected $casts = [
        'total_recipients'     => 'integer',
        'total_valid_numbers'  => 'integer',
        'total_invalid_numbers'=> 'integer',
        'total_sent'           => 'integer',
        'total_failed'         => 'integer',
        'total_delivered'      => 'integer',
    ];

    // ─── Relationships ──────────────────────────────────────────────────

    /**
     * The admin who created this batch.
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    /**
     * All recipients in this batch.
     */
    public function recipients(): HasMany
    {
        return $this->hasMany(SmsBatchRecipient::class, 'batch_id');
    }

    // ─── Helpers ────────────────────────────────────────────────────────

    /**
     * Recalculate and persist the aggregate totals from recipients.
     */
    public function recalculateTotals(): void
    {
        $this->total_recipients     = $this->recipients()->count();
        $this->total_valid_numbers  = $this->recipients()->where('validation_status', 'valid')->count();
        $this->total_invalid_numbers = $this->recipients()->where('validation_status', 'invalid')->count();
        $this->total_sent           = $this->recipients()->where('send_status', 'sent')->count();
        $this->total_delivered      = $this->recipients()->where('send_status', 'delivered')->count();
        $this->total_failed         = $this->recipients()
                                           ->whereIn('send_status', ['failed', 'invalid_number'])
                                           ->count();

        // Determine overall status
        if ($this->total_sent === 0 && $this->total_failed === 0 && $this->total_delivered === 0) {
            $this->overall_status = SmsBatchStatusEnum::PENDING;
        } elseif ($this->total_failed === $this->total_recipients) {
            $this->overall_status = SmsBatchStatusEnum::FAILED;
        } elseif ($this->total_failed > 0) {
            $this->overall_status = SmsBatchStatusEnum::COMPLETED_WITH_FAILURES;
        } else {
            $this->overall_status = SmsBatchStatusEnum::COMPLETED;
        }

        $this->save();
    }

    /**
     * Get the Arabic label for the send type.
     */
    public function getSendTypeLabelAttribute(): string
    {
        return SmsSendTypeEnum::label($this->send_type);
    }

    /**
     * Get the Arabic label for the overall status.
     */
    public function getOverallStatusLabelAttribute(): string
    {
        return SmsBatchStatusEnum::label($this->overall_status);
    }

    /**
     * Get the badge CSS class for the overall status.
     */
    public function getOverallStatusBadgeAttribute(): string
    {
        return SmsBatchStatusEnum::badgeClass($this->overall_status);
    }
}
