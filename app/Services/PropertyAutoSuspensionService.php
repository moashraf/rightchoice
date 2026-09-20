<?php

namespace App\Services;

use App\Models\aqar;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;

class PropertyAutoSuspensionService
{
    public const ACTIVE_LIFETIME_DAYS = 180;

    public function suspendExpiredProperties(): int
    {
        return aqar::query()
            ->where('status', 1)
            ->where('created_at', '<=', now()->subDays(self::ACTIVE_LIFETIME_DAYS))
            // A promotion expiry must only disable the featured state. Properties
            // that have been promoted remain published after their promotion ends.
            ->whereNull('vip_expires_at')
            ->update([
                'status' => 0,
                'vip' => 0,
                'auto_suspended_at' => now(),
            ]);
    }

    public function decorateCollection(Collection $properties): Collection
    {
        return $properties->transform(fn (aqar $property) => $this->decorate($property));
    }

    public function decorate(aqar $property): aqar
    {
        $baseDeadline = $property->created_at
            ? $property->created_at->copy()->addDays(self::ACTIVE_LIFETIME_DAYS)
            : null;
        // Once a property has been promoted, ending that promotion must not
        // become an automatic suspension deadline for the property itself.
        $promotionDefersSuspension = $property->vip_expires_at !== null;
        $effectiveDeadline = $promotionDefersSuspension ? null : $baseDeadline;
        $remaining = $this->remaining($effectiveDeadline);

        $property->setAttribute('auto_suspension_days', self::ACTIVE_LIFETIME_DAYS);
        $property->setAttribute('auto_suspension_at', $effectiveDeadline);
        $property->setAttribute('auto_suspension_deferred_by_promotion', $promotionDefersSuspension);
        $property->setAttribute('auto_suspension_remaining', $remaining['text']);
        $property->setAttribute('auto_suspension_remaining_parts', $remaining['parts']);
        $property->setAttribute('was_auto_suspended', $property->auto_suspended_at !== null);

        return $property;
    }

    private function remaining(?CarbonInterface $deadline): array
    {
        if (!$deadline) {
            return ['text' => null, 'parts' => []];
        }

        $remainingSeconds = now()->diffInSeconds($deadline, false);

        if ($remainingSeconds <= 0) {
            return ['text' => 'حان موعد التعليق', 'parts' => []];
        }

        $days = intdiv($remainingSeconds, 86400);
        $hours = intdiv($remainingSeconds % 86400, 3600);
        $minutes = intdiv($remainingSeconds % 3600, 60);

        return [
            'text' => "{$days} يوم و{$hours} ساعة و{$minutes} دقيقة",
            'parts' => [
                ['value' => $days, 'label' => 'يوم'],
                ['value' => $hours, 'label' => 'ساعة'],
                ['value' => $minutes, 'label' => 'دقيقة'],
            ],
        ];
    }
}
