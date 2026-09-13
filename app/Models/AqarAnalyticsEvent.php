<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * حدث تحليلي لعقار.
 *
 * يخزّن كل تفاعل مع العقار (مشاهدة، فتح تواصل، ضغطة واتساب، مفضلة، مقارنة، مشاركة)
 * كسجل مستقل في جدول aqar_analytics_events مع الحفاظ على خصوصية الزائر
 * (لا يخزَّن IP نصي، فقط visitor_hash مبني على APP_KEY).
 */
class AqarAnalyticsEvent extends Model
{
    use HasFactory;

    public const EVENT_VIEW            = 'view';
    public const EVENT_CONTACT_REVEAL  = 'contact_reveal';
    public const EVENT_WHATSAPP_CLICK  = 'whatsapp_click';
    public const EVENT_FAVORITE        = 'favorite';
    public const EVENT_COMPARISON      = 'comparison';
    public const EVENT_SHARE           = 'share';

    public const ALLOWED_EVENTS = [
        self::EVENT_VIEW,
        self::EVENT_CONTACT_REVEAL,
        self::EVENT_WHATSAPP_CLICK,
        self::EVENT_FAVORITE,
        self::EVENT_COMPARISON,
        self::EVENT_SHARE,
    ];

    protected $table = 'aqar_analytics_events';

    protected $fillable = [
        'aqar_id',
        'event_type',
        'user_id',
        'visitor_hash',
        'session_id',
        'source',
        'metadata',
        'occurred_at',
    ];

    protected $casts = [
        'aqar_id'     => 'integer',
        'user_id'     => 'integer',
        'metadata'    => 'array',
        'occurred_at' => 'datetime',
    ];

    public function aqar(): BelongsTo
    {
        return $this->belongsTo(aqar::class, 'aqar_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scopeOfType($query, string $type)
    {
        return $query->where('event_type', $type);
    }

    public function scopeForAqar($query, int $aqarId)
    {
        return $query->where('aqar_id', $aqarId);
    }

    public function scopeBetween($query, $from, $to)
    {
        return $query->whereBetween('occurred_at', [$from, $to]);
    }
}
