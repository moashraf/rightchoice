<?php

namespace Tests\Feature\Analytics;

use App\Models\aqar;
use App\Models\User;
use App\Policies\AqarAnalyticsPolicy;

class AqarAnalyticsPolicyTest extends AnalyticsTestCase
{
    public function test_owner_can_view_analytics(): void
    {
        $ownerId = $this->makeUser();
        $aqar    = aqar::find($this->makeAqar(['user_id' => $ownerId]));
        $owner   = User::find($ownerId);

        $policy = new AqarAnalyticsPolicy();
        $this->assertTrue($policy->view($owner, $aqar));
    }

    public function test_other_user_cannot_view_analytics(): void
    {
        $ownerId  = $this->makeUser();
        $otherId  = $this->makeUser();
        $aqar     = aqar::find($this->makeAqar(['user_id' => $ownerId]));
        $other    = User::find($otherId);

        $policy = new AqarAnalyticsPolicy();
        $this->assertFalse($policy->view($other, $aqar));
    }
}
