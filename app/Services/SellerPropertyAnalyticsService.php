<?php

namespace App\Services;

use App\Models\aqar;
use App\Models\AqarAnalyticsEvent;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

/**
 * خدمة حساب الإحصائيات الخاصة بلوحة تحليلات البائع لكل عقار.
 *
 * تعتمد فقط على COUNT/GROUP BY داخل جدول aqar_analytics_events دون تحميل Models كاملة،
 * وتخزّن ناتج كل فترة في Cache لمدة قصيرة لتخفيف الضغط.
 */
class SellerPropertyAnalyticsService
{
    /**
     * فترات مسموحة (بالأيام) للفلترة من الواجهة.
     */
    public const ALLOWED_PERIODS = [7, 30, 90];
    public const DEFAULT_PERIOD  = 30;
    public const CACHE_TTL_SECONDS = 300;

    public function summarize(aqar $aqar, int $days = self::DEFAULT_PERIOD): array
    {
        if (! in_array($days, self::ALLOWED_PERIODS, true)) {
            $days = self::DEFAULT_PERIOD;
        }

        $cacheKey = $this->cacheKey($aqar->id, $days);

        return Cache::remember($cacheKey, self::CACHE_TTL_SECONDS, function () use ($aqar, $days) {
            return $this->build($aqar, $days);
        });
    }

    protected function build(aqar $aqar, int $days): array
    {
        $now = Carbon::now();

        $currentStart  = $now->copy()->subDays($days - 1)->startOfDay();
        $currentEnd    = $now->copy()->endOfDay();
        $previousStart = $currentStart->copy()->subDays($days)->startOfDay();
        $previousEnd   = $currentStart->copy()->subSecond();

        $currentTotals  = $this->aggregate($aqar->id, $currentStart, $currentEnd);
        $previousTotals = $this->aggregate($aqar->id, $previousStart, $previousEnd);
        $dailyRaw       = $this->daily($aqar->id, $currentStart, $currentEnd);

        $daily = $this->fillGaps($dailyRaw, $currentStart, $currentEnd);

        $totalViews       = $currentTotals[AqarAnalyticsEvent::EVENT_VIEW]['count'] ?? 0;
        $uniqueViews      = $currentTotals[AqarAnalyticsEvent::EVENT_VIEW]['unique_visitors'] ?? 0;
        $contactReveals   = $currentTotals[AqarAnalyticsEvent::EVENT_CONTACT_REVEAL]['count'] ?? 0;
        $whatsappClicks   = $currentTotals[AqarAnalyticsEvent::EVENT_WHATSAPP_CLICK]['count'] ?? 0;
        $favorites        = $currentTotals[AqarAnalyticsEvent::EVENT_FAVORITE]['count'] ?? 0;
        $comparisons      = $currentTotals[AqarAnalyticsEvent::EVENT_COMPARISON]['count'] ?? 0;
        $shares           = $currentTotals[AqarAnalyticsEvent::EVENT_SHARE]['count'] ?? 0;

        $prevTotals = [
            'total_views'      => $previousTotals[AqarAnalyticsEvent::EVENT_VIEW]['count'] ?? 0,
            'unique_views'     => $previousTotals[AqarAnalyticsEvent::EVENT_VIEW]['unique_visitors'] ?? 0,
            'contact_reveals'  => $previousTotals[AqarAnalyticsEvent::EVENT_CONTACT_REVEAL]['count'] ?? 0,
            'whatsapp_clicks'  => $previousTotals[AqarAnalyticsEvent::EVENT_WHATSAPP_CLICK]['count'] ?? 0,
            'favorites'        => $previousTotals[AqarAnalyticsEvent::EVENT_FAVORITE]['count'] ?? 0,
            'comparisons'      => $previousTotals[AqarAnalyticsEvent::EVENT_COMPARISON]['count'] ?? 0,
            'shares'           => $previousTotals[AqarAnalyticsEvent::EVENT_SHARE]['count'] ?? 0,
        ];

        $current = [
            'total_views'      => (int) $totalViews,
            'unique_views'     => (int) $uniqueViews,
            'contact_reveals'  => (int) $contactReveals,
            'whatsapp_clicks'  => (int) $whatsappClicks,
            'favorites'        => (int) $favorites,
            'comparisons'      => (int) $comparisons,
            'shares'           => (int) $shares,
        ];

        return [
            'period_days'                  => $days,
            'period_start'                 => $currentStart->toDateString(),
            'period_end'                   => $currentEnd->toDateString(),
            'previous_period_start'        => $previousStart->toDateString(),
            'previous_period_end'          => $previousEnd->toDateString(),

            'total_views'                  => $current['total_views'],
            'unique_views'                 => $current['unique_views'],
            'contact_reveals'              => $current['contact_reveals'],
            'whatsapp_clicks'              => $current['whatsapp_clicks'],
            'favorites'                    => $current['favorites'],
            'comparisons'                  => $current['comparisons'],
            'shares'                       => $current['shares'],

            'contact_conversion_rate'      => $this->rate($current['contact_reveals'], $current['unique_views']),
            'whatsapp_conversion_rate'     => $this->rate($current['whatsapp_clicks'], $current['unique_views']),

            'daily_statistics'             => $daily,
            'previous_period_statistics'   => $prevTotals,
            'percentage_changes'           => $this->percentageChanges($current, $prevTotals),
        ];
    }

    /**
     * لوّح احصائيات كل نوع (Count + عدد الزوار الفريدين للـ view).
     *
     * @return array<string, array{count:int, unique_visitors:int}>
     */
    protected function aggregate(int $aqarId, Carbon $start, Carbon $end): array
    {
        $rows = AqarAnalyticsEvent::query()
            ->where('aqar_id', $aqarId)
            ->whereBetween('occurred_at', [$start, $end])
            ->selectRaw('event_type, COUNT(*) as total')
            ->groupBy('event_type')
            ->pluck('total', 'event_type')
            ->all();

        $result = [];
        foreach (AqarAnalyticsEvent::ALLOWED_EVENTS as $type) {
            $result[$type] = [
                'count'           => (int) ($rows[$type] ?? 0),
                'unique_visitors' => 0,
            ];
        }

        $uniqueViews = AqarAnalyticsEvent::query()
            ->where('aqar_id', $aqarId)
            ->where('event_type', AqarAnalyticsEvent::EVENT_VIEW)
            ->whereBetween('occurred_at', [$start, $end])
            ->selectRaw('COUNT(DISTINCT ' . $this->visitorKeyExpression() . ') as u')
            ->value('u');

        $result[AqarAnalyticsEvent::EVENT_VIEW]['unique_visitors'] = (int) $uniqueViews;

        return $result;
    }

    /**
     * إحصائيات مجمّعة يوميًا لجميع الأحداث المطلوبة.
     */
    protected function daily(int $aqarId, Carbon $start, Carbon $end): Collection
    {
        $rows = AqarAnalyticsEvent::query()
            ->where('aqar_id', $aqarId)
            ->whereBetween('occurred_at', [$start, $end])
            ->selectRaw('DATE(occurred_at) as day, event_type, COUNT(*) as total')
            ->groupBy('day', 'event_type')
            ->get();

        $uniqueRows = AqarAnalyticsEvent::query()
            ->where('aqar_id', $aqarId)
            ->where('event_type', AqarAnalyticsEvent::EVENT_VIEW)
            ->whereBetween('occurred_at', [$start, $end])
            ->selectRaw('DATE(occurred_at) as day, COUNT(DISTINCT ' . $this->visitorKeyExpression() . ') as u')
            ->groupBy('day')
            ->pluck('u', 'day');

        $indexed = [];
        foreach ($rows as $row) {
            $day = (string) $row->day;
            $indexed[$day] ??= [
                'date'            => $day,
                'views'           => 0,
                'unique_views'    => 0,
                'contact_reveals' => 0,
                'whatsapp_clicks' => 0,
                'favorites'       => 0,
                'comparisons'     => 0,
                'shares'          => 0,
            ];

            switch ($row->event_type) {
                case AqarAnalyticsEvent::EVENT_VIEW:
                    $indexed[$day]['views'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_CONTACT_REVEAL:
                    $indexed[$day]['contact_reveals'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_WHATSAPP_CLICK:
                    $indexed[$day]['whatsapp_clicks'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_FAVORITE:
                    $indexed[$day]['favorites'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_COMPARISON:
                    $indexed[$day]['comparisons'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_SHARE:
                    $indexed[$day]['shares'] = (int) $row->total;
                    break;
            }
        }

        foreach ($uniqueRows as $day => $count) {
            $day = (string) $day;
            $indexed[$day] ??= [
                'date'            => $day,
                'views'           => 0,
                'unique_views'    => 0,
                'contact_reveals' => 0,
                'whatsapp_clicks' => 0,
                'favorites'       => 0,
                'comparisons'     => 0,
                'shares'          => 0,
            ];
            $indexed[$day]['unique_views'] = (int) $count;
        }

        return collect($indexed)->values();
    }

    /**
     * تعبئة الأيام الفارغة بأصفار كي يعمل الرسم بلا ثغرات.
     */
    protected function fillGaps(Collection $daily, Carbon $start, Carbon $end): array
    {
        $byDate = $daily->keyBy('date');
        $days = [];
        $cursor = $start->copy()->startOfDay();
        while ($cursor <= $end) {
            $date = $cursor->toDateString();
            $days[] = $byDate->get($date) ?? [
                'date'            => $date,
                'views'           => 0,
                'unique_views'    => 0,
                'contact_reveals' => 0,
                'whatsapp_clicks' => 0,
                'favorites'       => 0,
                'comparisons'     => 0,
                'shares'          => 0,
            ];
            $cursor->addDay();
        }
        return $days;
    }

    /**
     * حساب نسبة تحويل مع معالجة القسمة على صفر. القيمة عائمة نسبة مئوية.
     */
    protected function rate(int $numerator, int $denominator): float
    {
        if ($denominator <= 0) {
            return 0.0;
        }
        return round(($numerator / $denominator) * 100, 2);
    }

    /**
     * حساب نسبة التغير بين الفترة الحالية والسابقة لكل مقياس.
     *
     * @param array<string,int> $current
     * @param array<string,int> $previous
     * @return array<string,float|null>
     */
    protected function percentageChanges(array $current, array $previous): array
    {
        $keys = array_keys($current);
        $result = [];
        foreach ($keys as $key) {
            $cur  = (int) ($current[$key] ?? 0);
            $prev = (int) ($previous[$key] ?? 0);
            if ($prev === 0) {
                $result[$key] = $cur > 0 ? 100.0 : 0.0;
            } else {
                $result[$key] = round((($cur - $prev) / $prev) * 100, 2);
            }
        }
        return $result;
    }

    protected function cacheKey(int $aqarId, int $days): string
    {
        return "seller_analytics:aqar:{$aqarId}:days:{$days}";
    }

    /**
     * تعبير SQL لعدّ الزوار الفريدين بشكل يعمل على MySQL و SQLite.
     * يجمع user_id و visitor_hash في مفتاح واحد.
     */
    protected function visitorKeyExpression(): string
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'sqlite') {
            return "COALESCE(CAST(user_id AS TEXT), '0') || '#' || COALESCE(visitor_hash, '')";
        }
        return "CONCAT(COALESCE(user_id, 0), '#', COALESCE(visitor_hash, ''))";
    }

    /**
     * جلب ملخصات مبسّطة لعدة عقارات دفعة واحدة (لصفحة عقارات المستخدم).
     * يستخدم استعلامًا واحدًا مجمّعًا (GROUP BY event_type + aqar_id) لتفادي N+1.
     *
     * @param  array<int>|Collection  $aqarIds
     * @return array<int,array{views:int,contact_reveals:int,whatsapp_clicks:int,favorites:int,comparisons:int,shares:int}>
     */
    public function summariesForAqarIds($aqarIds, int $days = self::DEFAULT_PERIOD): array
    {
        $aqarIds = collect($aqarIds)->filter()->map(fn ($id) => (int) $id)->unique()->values();
        if ($aqarIds->isEmpty()) {
            return [];
        }
        if (! in_array($days, self::ALLOWED_PERIODS, true)) {
            $days = self::DEFAULT_PERIOD;
        }

        $start = Carbon::now()->subDays($days - 1)->startOfDay();
        $end   = Carbon::now()->endOfDay();

        $rows = AqarAnalyticsEvent::query()
            ->whereIn('aqar_id', $aqarIds->all())
            ->whereBetween('occurred_at', [$start, $end])
            ->selectRaw('aqar_id, event_type, COUNT(*) as total')
            ->groupBy('aqar_id', 'event_type')
            ->get();

        $result = [];
        foreach ($aqarIds as $id) {
            $result[$id] = [
                'views'           => 0,
                'contact_reveals' => 0,
                'whatsapp_clicks' => 0,
                'favorites'       => 0,
                'comparisons'     => 0,
                'shares'          => 0,
            ];
        }
        foreach ($rows as $row) {
            $id = (int) $row->aqar_id;
            switch ($row->event_type) {
                case AqarAnalyticsEvent::EVENT_VIEW:
                    $result[$id]['views'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_CONTACT_REVEAL:
                    $result[$id]['contact_reveals'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_WHATSAPP_CLICK:
                    $result[$id]['whatsapp_clicks'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_FAVORITE:
                    $result[$id]['favorites'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_COMPARISON:
                    $result[$id]['comparisons'] = (int) $row->total;
                    break;
                case AqarAnalyticsEvent::EVENT_SHARE:
                    $result[$id]['shares'] = (int) $row->total;
                    break;
            }
        }
        return $result;
    }
}
