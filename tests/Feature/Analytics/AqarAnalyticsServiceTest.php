<?php

namespace Tests\Feature\Analytics;

use App\Models\aqar;
use App\Models\AqarAnalyticsEvent;
use App\Models\User;
use App\Services\AqarAnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AqarAnalyticsServiceTest extends AnalyticsTestCase
{
    protected AqarAnalyticsService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = app(AqarAnalyticsService::class);
    }

    public function test_it_records_view_event_for_visitor(): void
    {
        $aqar = aqar::find($this->makeAqar());

        $this->service->trackView($aqar, Request::create('/aqars/x', 'GET'));

        $this->assertDatabaseHas('aqar_analytics_events', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_VIEW,
            'user_id'    => null,
        ]);
    }

    public function test_it_records_view_event_for_authenticated_user(): void
    {
        $ownerId = $this->makeUser();
        $viewerId = $this->makeUser();
        $aqar = aqar::find($this->makeAqar(['user_id' => $ownerId]));

        Auth::loginUsingId($viewerId);

        $this->service->trackView($aqar, Request::create('/aqars/x', 'GET'));

        $this->assertDatabaseHas('aqar_analytics_events', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_VIEW,
            'user_id'    => $viewerId,
        ]);
    }

    public function test_it_does_not_record_view_for_owner(): void
    {
        $ownerId = $this->makeUser();
        $aqar = aqar::find($this->makeAqar(['user_id' => $ownerId]));

        Auth::loginUsingId($ownerId);

        $this->service->trackView($aqar, Request::create('/aqars/x', 'GET'));

        $this->assertDatabaseCount('aqar_analytics_events', 0);
    }

    public function test_it_does_not_record_view_for_admin(): void
    {
        $ownerId = $this->makeUser();
        $adminId = $this->makeUser(['isAdmin' => 1]);
        $aqar = aqar::find($this->makeAqar(['user_id' => $ownerId]));

        Auth::loginUsingId($adminId);

        $this->service->trackView($aqar, Request::create('/aqars/x', 'GET'));

        $this->assertDatabaseCount('aqar_analytics_events', 0);
    }

    public function test_it_deduplicates_unique_view_within_24_hours(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $viewerId = $this->makeUser();

        Auth::loginUsingId($viewerId);

        $this->service->trackView($aqar, Request::create('/aqars/x', 'GET'));

        $this->travel(45)->minutes();
        $this->service->trackView($aqar, Request::create('/aqars/x', 'GET'));

        $rows = DB::table('aqar_analytics_events')
            ->where('aqar_id', $aqar->id)
            ->where('event_type', AqarAnalyticsEvent::EVENT_VIEW)
            ->get();

        $this->assertCount(2, $rows, 'يجب تسجيل حدثين إجماليين بفارق 45 دقيقة');

        $uniqueFlags = $rows->map(function ($r) {
            $meta = $r->metadata ? json_decode($r->metadata, true) : [];
            return $meta['is_unique'] ?? null;
        })->filter(fn ($v) => $v === true);

        $this->assertCount(1, $uniqueFlags, 'يجب أن يكون هناك مشاهدة فريدة واحدة فقط خلال 24 ساعة');
    }

    public function test_it_prevents_duplicate_total_view_within_30_minutes(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $viewerId = $this->makeUser();
        Auth::loginUsingId($viewerId);

        $this->service->trackView($aqar, Request::create('/aqars/x', 'GET'));
        $this->travel(5)->minutes();
        $this->service->trackView($aqar, Request::create('/aqars/x', 'GET'));

        $this->assertEquals(
            1,
            DB::table('aqar_analytics_events')->where('event_type', 'view')->count()
        );
    }

    public function test_it_records_contact_reveal_and_whatsapp_click(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $viewerId = $this->makeUser();
        Auth::loginUsingId($viewerId);

        $this->service->trackContactReveal($aqar, Request::create('/aqars/x', 'GET'));
        $this->service->trackWhatsappClick($aqar, Request::create('/aqars/x', 'GET'));

        $this->assertDatabaseHas('aqar_analytics_events', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_CONTACT_REVEAL,
        ]);
        $this->assertDatabaseHas('aqar_analytics_events', [
            'aqar_id'    => $aqar->id,
            'event_type' => AqarAnalyticsEvent::EVENT_WHATSAPP_CLICK,
        ]);
    }

    public function test_it_records_favorite_and_comparison(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $viewerId = $this->makeUser();
        Auth::loginUsingId($viewerId);

        $this->service->trackFavorite($aqar, Request::create('/x', 'GET'));
        $this->service->trackComparison($aqar, Request::create('/x', 'GET'));

        $this->assertDatabaseCount('aqar_analytics_events', 2);
    }

    public function test_it_ignores_non_published_aqar(): void
    {
        $aqar = aqar::find($this->makeAqar(['status' => 0]));

        $this->service->trackView($aqar, Request::create('/x', 'GET'));
        $this->service->trackContactReveal($aqar, Request::create('/x', 'GET'));

        $this->assertDatabaseCount('aqar_analytics_events', 0);
    }

    public function test_visitor_hash_does_not_expose_raw_ip(): void
    {
        $aqar = aqar::find($this->makeAqar());
        $req  = Request::create('/x', 'GET', server: ['REMOTE_ADDR' => '203.0.113.10']);

        $this->service->trackView($aqar, $req);

        $row = DB::table('aqar_analytics_events')->first();
        $this->assertNotNull($row);
        $this->assertNotEmpty($row->visitor_hash);
        $this->assertStringNotContainsString('203.0.113.10', (string) $row->visitor_hash);
    }
}
