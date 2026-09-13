<?php

namespace Tests\Feature\Analytics;

use App\Http\Controllers\AqarAnalyticsTrackingController;
use App\Models\aqar;
use App\Models\AqarAnalyticsEvent;
use App\Services\AqarAnalyticsService;
use Illuminate\Http\Request;

/**
 * اختبارات لنقطة نهاية تسجيل الأحداث (بدون المرور عبر HTTP stack كامل).
 * نستدعي الـ Controller مباشرةً لتفادي تعقيدات mode/session/middleware.
 */
class AqarAnalyticsTrackingEndpointTest extends AnalyticsTestCase
{
    protected AqarAnalyticsTrackingController $controller;
    protected AqarAnalyticsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new AqarAnalyticsTrackingController();
        $this->service    = app(AqarAnalyticsService::class);
    }

    public function test_it_rejects_unknown_event_type(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $request = Request::create('/aqar-analytics/track', 'POST', [
            'aqar_id'    => $aqar->id,
            'event_type' => 'unknown_event',
        ]);

        $response = $this->controller->store($request, $this->service);
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_it_rejects_non_existent_aqar(): void
    {
        $request = Request::create('/aqar-analytics/track', 'POST', [
            'aqar_id'    => 999999,
            'event_type' => AqarAnalyticsEvent::EVENT_COMPARISON,
        ]);

        $response = $this->controller->store($request, $this->service);
        $this->assertEquals(422, $response->getStatusCode());
    }

    public function test_it_rejects_unpublished_aqar(): void
    {
        $aqar = aqar::find($this->makeAqar(['status' => 0]));
        $request = Request::create('/aqar-analytics/track', 'POST', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_COMPARISON,
        ]);

        $response = $this->controller->store($request, $this->service);
        $this->assertEquals(404, $response->getStatusCode());
    }

    public function test_it_records_comparison_and_share_events_from_visitors(): void
    {
        $aqar = aqar::find($this->makeAqar());

        $shareRequest = Request::create('/aqar-analytics/track', 'POST', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_SHARE,
        ]);
        $r1 = $this->controller->store($shareRequest, $this->service);

        $cmpRequest = Request::create('/aqar-analytics/track', 'POST', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_COMPARISON,
        ]);
        $r2 = $this->controller->store($cmpRequest, $this->service);

        $this->assertEquals(200, $r1->getStatusCode());
        $this->assertEquals(200, $r2->getStatusCode());

        $this->assertDatabaseHas('aqar_analytics_events', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_SHARE,
        ]);
        $this->assertDatabaseHas('aqar_analytics_events', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_COMPARISON,
        ]);
    }
}
