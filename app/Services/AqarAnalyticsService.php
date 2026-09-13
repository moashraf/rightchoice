<?php

namespace App\Services;

use App\Models\aqar;
use App\Models\AqarAnalyticsEvent;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/**
 * خدمة تسجيل أحداث التحليلات الخاصة بالعقار.
 *
 * لا تكرّر منطق التسجيل داخل أكثر من Controller. جميع الأحداث تمرّ عبر هذه الخدمة.
 *
 * قواعد الخصوصية:
 *  - لا يخزَّن IP نصي.
 *  - visitor_hash = sha256(APP_KEY + session_id | fallback IP).
 *  - metadata محدود (source, referrer host فقط) ولا يحمل بيانات حساسة.
 */
class AqarAnalyticsService
{
    /**
     * مدة اعتبار الزائر "فريدًا" على العقار (بالساعات).
     */
    public const UNIQUE_VIEW_WINDOW_HOURS = 24;

    /**
     * الحدّ الأدنى (بالدقائق) بين مشاهدتين إجماليتين لنفس الزائر لنفس العقار.
     */
    public const REPEAT_VIEW_WINDOW_MINUTES = 30;

    public function trackView(aqar $aqar, ?Request $request = null, array $metadata = []): ?AqarAnalyticsEvent
    {
        return $this->recordViewEvent($aqar, $request, $metadata);
    }

    public function trackContactReveal(aqar $aqar, ?Request $request = null, array $metadata = []): ?AqarAnalyticsEvent
    {
        return $this->record($aqar, AqarAnalyticsEvent::EVENT_CONTACT_REVEAL, $request, $metadata);
    }

    public function trackWhatsappClick(aqar $aqar, ?Request $request = null, array $metadata = []): ?AqarAnalyticsEvent
    {
        return $this->record($aqar, AqarAnalyticsEvent::EVENT_WHATSAPP_CLICK, $request, $metadata);
    }

    public function trackFavorite(aqar $aqar, ?Request $request = null, array $metadata = []): ?AqarAnalyticsEvent
    {
        return $this->record($aqar, AqarAnalyticsEvent::EVENT_FAVORITE, $request, $metadata);
    }

    public function trackComparison(aqar $aqar, ?Request $request = null, array $metadata = []): ?AqarAnalyticsEvent
    {
        return $this->record($aqar, AqarAnalyticsEvent::EVENT_COMPARISON, $request, $metadata);
    }

    public function trackShare(aqar $aqar, ?Request $request = null, array $metadata = []): ?AqarAnalyticsEvent
    {
        return $this->record($aqar, AqarAnalyticsEvent::EVENT_SHARE, $request, $metadata);
    }

    /**
     * المعالجة العامة لمشاهدة العقار مع قواعد الاستبعاد ومنع التكرار.
     *
     * لا يُسجَّل شيء لصاحب العقار أو للأدمن. المشاهدة الإجمالية لا تتكرر خلال 30 دقيقة،
     * والمشاهدة الفريدة تُحدَّد بوجود سجل خلال آخر 24 ساعة لنفس الزائر (تُحفظ في metadata.is_unique).
     */
    protected function recordViewEvent(aqar $aqar, ?Request $request, array $metadata): ?AqarAnalyticsEvent
    {
        try {
            if (! $this->shouldTrack($aqar)) {
                return null;
            }

            $user = Auth::user();
            $visitorHash = $this->resolveVisitorHash($request, $user);
            $sessionId   = $this->resolveSessionId($request);

            $now = Carbon::now();

            $recentTotalExists = AqarAnalyticsEvent::query()
                ->where('aqar_id', $aqar->id)
                ->where('event_type', AqarAnalyticsEvent::EVENT_VIEW)
                ->when($user, fn ($q) => $q->where('user_id', $user->getAuthIdentifier()))
                ->when(! $user && $visitorHash, fn ($q) => $q->where('visitor_hash', $visitorHash))
                ->where('occurred_at', '>=', $now->copy()->subMinutes(self::REPEAT_VIEW_WINDOW_MINUTES))
                ->exists();

            if ($recentTotalExists) {
                return null;
            }

            $hasEventInUniqueWindow = AqarAnalyticsEvent::query()
                ->where('aqar_id', $aqar->id)
                ->where('event_type', AqarAnalyticsEvent::EVENT_VIEW)
                ->when($user, fn ($q) => $q->where('user_id', $user->getAuthIdentifier()))
                ->when(! $user && $visitorHash, fn ($q) => $q->where('visitor_hash', $visitorHash))
                ->where('occurred_at', '>=', $now->copy()->subHours(self::UNIQUE_VIEW_WINDOW_HOURS))
                ->exists();

            $isUnique = ! $hasEventInUniqueWindow;

            $metadata = array_merge($metadata, [
                'is_unique' => $isUnique,
            ]);

            return $this->persist(
                aqar: $aqar,
                type: AqarAnalyticsEvent::EVENT_VIEW,
                user: $user,
                visitorHash: $visitorHash,
                sessionId: $sessionId,
                request: $request,
                metadata: $metadata,
                occurredAt: $now,
            );
        } catch (Throwable $e) {
            $this->logFailure(AqarAnalyticsEvent::EVENT_VIEW, $aqar, $e);
            return null;
        }
    }

    /**
     * تسجيل حدث تحليلي عام (غير حدث view). فشل التسجيل لا يمنع باقي العمليات.
     */
    protected function record(
        aqar $aqar,
        string $type,
        ?Request $request,
        array $metadata
    ): ?AqarAnalyticsEvent {
        try {
            if (! in_array($type, AqarAnalyticsEvent::ALLOWED_EVENTS, true)) {
                Log::warning('[AqarAnalytics] event type غير مسموح', ['type' => $type]);
                return null;
            }

            if (! $this->shouldTrack($aqar)) {
                return null;
            }

            $user = Auth::user();
            $visitorHash = $this->resolveVisitorHash($request, $user);
            $sessionId   = $this->resolveSessionId($request);

            return $this->persist(
                aqar: $aqar,
                type: $type,
                user: $user,
                visitorHash: $visitorHash,
                sessionId: $sessionId,
                request: $request,
                metadata: $metadata,
                occurredAt: Carbon::now(),
            );
        } catch (Throwable $e) {
            $this->logFailure($type, $aqar, $e);
            return null;
        }
    }

    /**
     * تحديد إمكانية تسجيل الحدث: العقار يجب أن يكون منشورًا، وليس للمالك، وليس للأدمن.
     */
    protected function shouldTrack(aqar $aqar): bool
    {
        if (! $aqar->exists || (int) $aqar->status !== 1) {
            return false;
        }

        $user = Auth::user();
        if (! $user) {
            return true;
        }

        if ((int) $aqar->user_id === (int) $user->getAuthIdentifier()) {
            return false;
        }

        if ($this->isAdmin($user)) {
            return false;
        }

        return true;
    }

    protected function isAdmin(Authenticatable $user): bool
    {
        if (method_exists($user, 'isAdminRole') && $user->isAdminRole()) {
            return true;
        }

        return isset($user->isAdmin) && (int) $user->isAdmin === 1;
    }

    /**
     * توليد hash خاص بالزائر (بدون تخزين IP).
     */
    protected function resolveVisitorHash(?Request $request, ?Authenticatable $user): ?string
    {
        $seed = null;

        if ($request) {
            try {
                if ($request->hasSession()) {
                    $seed = $request->session()->getId();
                }
            } catch (Throwable $e) {
                $seed = null;
            }

            if (! $seed) {
                $seed = $request->ip();
            }
        }

        if (! $seed && $user) {
            $seed = 'user:' . $user->getAuthIdentifier();
        }

        if (! $seed) {
            return null;
        }

        return hash_hmac('sha256', $seed, (string) config('app.key'));
    }

    protected function resolveSessionId(?Request $request): ?string
    {
        if (! $request) {
            return null;
        }
        try {
            if (! $request->hasSession()) {
                return null;
            }
            return substr($request->session()->getId(), 0, 100);
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * حفظ الحدث في قاعدة البيانات. metadata يُمرّر بشكل مصفى فقط.
     */
    protected function persist(
        aqar $aqar,
        string $type,
        ?Authenticatable $user,
        ?string $visitorHash,
        ?string $sessionId,
        ?Request $request,
        array $metadata,
        Carbon $occurredAt
    ): AqarAnalyticsEvent {
        $source = $this->resolveSource($request, $metadata);

        $safeMetadata = $this->sanitizeMetadata($metadata);

        $event = AqarAnalyticsEvent::create([
            'aqar_id'      => $aqar->id,
            'event_type'   => $type,
            'user_id'      => $user?->getAuthIdentifier(),
            'visitor_hash' => $visitorHash,
            'session_id'   => $sessionId,
            'source'       => $source,
            'metadata'     => $safeMetadata ?: null,
            'occurred_at'  => $occurredAt,
        ]);

        $this->forgetAqarCache($aqar->id);

        return $event;
    }

    protected function resolveSource(?Request $request, array $metadata): ?string
    {
        if (! empty($metadata['source']) && is_string($metadata['source'])) {
            return substr($metadata['source'], 0, 40);
        }
        if (! $request) {
            return null;
        }
        $referrer = $request->headers->get('referer');
        if (! $referrer) {
            return null;
        }
        $host = parse_url($referrer, PHP_URL_HOST);
        return $host ? substr($host, 0, 40) : null;
    }

    /**
     * تصفية metadata: تُقبل مفاتيح محدودة فقط، وقيم قصيرة، ولا معلومات حساسة.
     */
    protected function sanitizeMetadata(array $metadata): array
    {
        $allowedKeys = ['source', 'is_unique', 'page', 'action'];
        $clean = [];
        foreach ($allowedKeys as $key) {
            if (! array_key_exists($key, $metadata)) {
                continue;
            }
            $value = $metadata[$key];
            if (is_bool($value) || is_int($value)) {
                $clean[$key] = $value;
                continue;
            }
            if (is_string($value)) {
                $clean[$key] = substr($value, 0, 80);
            }
        }
        return $clean;
    }

    protected function logFailure(string $type, aqar $aqar, Throwable $e): void
    {
        Log::error('[AqarAnalytics] فشل تسجيل حدث', [
            'type'    => $type,
            'aqar_id' => $aqar->id ?? null,
            'error'   => $e->getMessage(),
        ]);
    }

    /**
     * إبطال Cache الإحصائيات المتراكمة للعقار عند وصول حدث جديد.
     */
    protected function forgetAqarCache(int $aqarId): void
    {
        try {
            foreach ([7, 30, 90] as $days) {
                Cache::forget("seller_analytics:aqar:{$aqarId}:days:{$days}");
            }
        } catch (Throwable $e) {
        }
    }
}
