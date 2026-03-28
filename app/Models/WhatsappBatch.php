<?php

namespace App\Models;

use App\Enums\WhatsappBatchStatusEnum;
use App\Enums\WhatsappSendTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappBatch extends Model
{
    protected $table = 'whatsapp_batches';

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
        'total_recipients'      => 'integer',
        'total_valid_numbers'   => 'integer',
        'total_invalid_numbers' => 'integer',
        'total_sent'            => 'integer',
        'total_failed'          => 'integer',
        'total_delivered'       => 'integer',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function recipients(): HasMany
    {
        return $this->hasMany(WhatsappBatchRecipient::class, 'batch_id');
    }

    public function recalculateTotals(): void
    {
        $this->total_recipients      = $this->recipients()->count();
        $this->total_valid_numbers   = $this->recipients()->where('validation_status', 'valid')->count();
        $this->total_invalid_numbers = $this->recipients()->where('validation_status', 'invalid')->count();
        $this->total_sent            = $this->recipients()->where('send_status', 'sent')->count();
        $this->total_delivered       = $this->recipients()->where('send_status', 'delivered')->count();
        $this->total_failed          = $this->recipients()
                                            ->whereIn('send_status', ['failed', 'invalid_number'])
                                            ->count();

        if ($this->total_sent === 0 && $this->total_failed === 0 && $this->total_delivered === 0) {
            $this->overall_status = WhatsappBatchStatusEnum::PENDING;
        } elseif ($this->total_failed === $this->total_recipients) {
            $this->overall_status = WhatsappBatchStatusEnum::FAILED;
        } elseif ($this->total_failed > 0) {
            $this->overall_status = WhatsappBatchStatusEnum::COMPLETED_WITH_FAILURES;
        } else {
            $this->overall_status = WhatsappBatchStatusEnum::COMPLETED;
        }

        $this->save();
    }

    public function getSendTypeLabelAttribute(): string
    {
        return WhatsappSendTypeEnum::label($this->send_type);
    }

    public function getOverallStatusLabelAttribute(): string
    {
        return WhatsappBatchStatusEnum::label($this->overall_status);
    }

    public function getOverallStatusBadgeAttribute(): string
    {
        return WhatsappBatchStatusEnum::badgeClass($this->overall_status);
    }
}
