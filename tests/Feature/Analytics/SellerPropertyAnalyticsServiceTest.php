<?php

namespace Tests\Feature\Analytics;

use App\Models\aqar;
use App\Models\AqarAnalyticsEvent;
use App\Services\SellerPropertyAnalyticsService;
use Illuminate\Support\Carbon;

class SellerPropertyAnalyticsServiceTest extends AnalyticsTestCase
{
    protected SellerPropertyAnalyticsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(SellerPropertyAnalyticsService::class);
    }

    protected function fabricate(int $aqarId, string $type, Carbon $when, ?int $userId = null, ?string $visitor = null): void
    {
        AqarAnalyticsEvent::create([
            'aqar_id'      => $aqarId,
            'event_type'   => $type,
            'user_id'      => $userId,
            'visitor_hash' => $visitor,
            'occurred_at'  => $when,
        ]);
    }

    public function test_it_returns_zeros_when_no_events(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $result = $this->service->summarize($aqar, 30);

        $this->assertSame(0, $result['total_views']);
        $this->assertSame(0, $result['unique_views']);
        $this->assertSame(0, $result['contact_reveals']);
        $this->assertSame(0, $result['whatsapp_clicks']);
        $this->assertSame(0.0, $result['contact_conversion_rate']);
        $this->assertSame(0.0, $result['whatsapp_conversion_rate']);
        $this->assertCount(30, $result['daily_statistics']);
    }

    public function test_totals_and_uniques_are_correct(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $now = Carbon::now();

        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(1), null, 'v-a');
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(2), null, 'v-a');
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(3), null, 'v-b');
        $this->fabricate($aqar->id, 'contact_reveal', $now->copy()->subDays(2), 1);
        $this->fabricate($aqar->id, 'whatsapp_click', $now->copy()->subDays(1), 1);
        $this->fabricate($aqar->id, 'favorite', $now->copy()->subDays(1), 2);
        $this->fabricate($aqar->id, 'comparison', $now->copy()->subDays(1), 3);

        $result = $this->service->summarize($aqar, 30);

        $this->assertSame(3, $result['total_views']);
        $this->assertSame(2, $result['unique_views']);
        $this->assertSame(1, $result['contact_reveals']);
        $this->assertSame(1, $result['whatsapp_clicks']);
        $this->assertSame(1, $result['favorites']);
        $this->assertSame(1, $result['comparisons']);
    }

    public function test_conversion_rate_is_correct_and_zero_safe(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $now = Carbon::now();

        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(1), null, 'v-a');
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(1), null, 'v-b');
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(1), null, 'v-c');
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(1), null, 'v-d');
        $this->fabricate($aqar->id, 'contact_reveal', $now->copy()->subDays(1), 1);

        $result = $this->service->summarize($aqar, 30);

        $this->assertSame(4, $result['unique_views']);
        $this->assertSame(1, $result['contact_reveals']);
        $this->assertSame(25.0, $result['contact_conversion_rate']);
    }

    public function test_conversion_rate_zero_when_no_unique_views(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $now = Carbon::now();

        $this->fabricate($aqar->id, 'contact_reveal', $now->copy()->subDays(1), 1);

        $result = $this->service->summarize($aqar, 30);

        $this->assertSame(0, $result['unique_views']);
        $this->assertSame(0.0, $result['contact_conversion_rate']);
    }

    public function test_period_filter_7_30_90_days(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $now = Carbon::now();

        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(3),  null, 'v-1');
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(20), null, 'v-2');
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(60), null, 'v-3');

        $this->assertSame(1, $this->service->summarize($aqar, 7)['total_views']);
        $this->assertSame(2, $this->service->summarize(aqar::find($aqar->id), 30)['total_views']);
        $this->assertSame(3, $this->service->summarize(aqar::find($aqar->id), 90)['total_views']);
    }

    public function test_previous_period_comparison_and_percentage_change(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $now = Carbon::now();

        // current period: last 30 days
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(5),  null, 'v-1');
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(10), null, 'v-2');
        // previous period: 30-60 days ago
        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(40), null, 'v-3');

        $result = $this->service->summarize($aqar, 30);
        $this->assertSame(2, $result['total_views']);
        $this->assertSame(1, $result['previous_period_statistics']['total_views']);
        $this->assertSame(100.0, $result['percentage_changes']['total_views']);
    }

    public function test_percentage_change_when_previous_is_zero(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $now = Carbon::now();

        $this->fabricate($aqar->id, 'view', $now->copy()->subDays(1), null, 'v-1');

        $result = $this->service->summarize($aqar, 30);
        $this->assertSame(100.0, $result['percentage_changes']['total_views']);
    }

    public function test_events_of_other_properties_are_isolated(): void
    {
        $mine   = aqar::find($this->makeAqar());
        $others = aqar::find($this->makeAqar());
        $now = Carbon::now();

        $this->fabricate($mine->id,   'view', $now->copy()->subDays(1), null, 'a');
        $this->fabricate($others->id, 'view', $now->copy()->subDays(1), null, 'b');
        $this->fabricate($others->id, 'view', $now->copy()->subDays(1), null, 'c');

        $mineResult = $this->service->summarize($mine, 30);
        $this->assertSame(1, $mineResult['total_views']);
    }

    public function test_summaries_for_multiple_aqar_ids(): void
    {
        $a = aqar::find($this->makeAqar());
        $b = aqar::find($this->makeAqar());
        $now = Carbon::now();

        $this->fabricate($a->id, 'view',           $now->copy()->subDays(1));
        $this->fabricate($a->id, 'view',           $now->copy()->subDays(1));
        $this->fabricate($a->id, 'contact_reveal', $now->copy()->subDays(1));
        $this->fabricate($b->id, 'whatsapp_click', $now->copy()->subDays(2));

        $result = $this->service->summariesForAqarIds([$a->id, $b->id], 30);

        $this->assertSame(2, $result[$a->id]['views']);
        $this->assertSame(1, $result[$a->id]['contact_reveals']);
        $this->assertSame(0, $result[$a->id]['whatsapp_clicks']);
        $this->assertSame(1, $result[$b->id]['whatsapp_clicks']);
    }
}
