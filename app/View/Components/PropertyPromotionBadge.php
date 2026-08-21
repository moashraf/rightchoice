<?php

namespace App\View\Components;

use App\Models\aqar;
use Illuminate\View\Component;
use Illuminate\View\View;

class PropertyPromotionBadge extends Component
{
    public bool $visible;
    public int $durationDays;
    public string $durationClass;

    public function __construct(aqar $property)
    {
        $this->visible = $property->isPromotionActive();
        $this->durationDays = $this->resolveDurationDays($property);
        $this->durationClass = 'rc-promotion-badge--' . $this->durationDays;
    }

    public function render(): View
    {
        return view('components.property-promotion-badge');
    }

    private function resolveDurationDays(aqar $property): int
    {
        if (!$property->vip_started_at || !$property->vip_expires_at) {
            return 7;
        }

        $actualDuration = (int) round(
            $property->vip_started_at->diffInMinutes($property->vip_expires_at) / 1440
        );

        return collect([7, 14, 30])
            ->sortBy(fn (int $duration) => abs($duration - $actualDuration))
            ->first();
    }
}
