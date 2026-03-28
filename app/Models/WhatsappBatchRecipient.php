<?php

namespace App\Models;

use App\Enums\WhatsappSendStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class WhatsappBatchRecipient extends Model
{
    protected $table = 'whatsapp_batch_recipients';

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

    public function batch(): BelongsTo
    {
        return $this->belongsTo(WhatsappBatch::class, 'batch_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statusLogs(): HasMany
    {
        return $this->hasMany(WhatsappStatusLog::class, 'batch_recipient_id');
    }

    public function updateStatus(string $newStatus, ?string $notes = null, ?string $providerResponse = null): void
    {
        $oldStatus = $this->send_status;

        $this->send_status = $newStatus;

        if ($newStatus === WhatsappSendStatusEnum::SENT && !$this->sent_at) {
            $this->sent_at = now();
        }

        if ($newStatus === WhatsappSendStatusEnum::DELIVERED && !$this->delivered_at) {
            $this->delivered_at = now();
        }

        $this->save();

        WhatsappStatusLog::create([
            'batch_recipient_id' => $this->id,
            'old_status'         => $oldStatus,
            'new_status'         => $newStatus,
            'notes'              => $notes,
            'provider_response'  => $providerResponse,
        ]);
    }

    public function getSendStatusLabelAttribute(): string
    {
        return WhatsappSendStatusEnum::label($this->send_status);
    }

    public function getSendStatusBadgeAttribute(): string
    {
        return WhatsappSendStatusEnum::badgeClass($this->send_status);
    }
}
