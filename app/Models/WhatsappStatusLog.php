<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappStatusLog extends Model
{
    protected $table = 'whatsapp_status_logs';

    const UPDATED_AT = null;

    protected $fillable = [
        'batch_recipient_id',
        'old_status',
        'new_status',
        'notes',
        'provider_response',
    ];

    public function recipient(): BelongsTo
    {
        return $this->belongsTo(WhatsappBatchRecipient::class, 'batch_recipient_id');
    }
}
