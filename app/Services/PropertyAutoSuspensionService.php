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
            ->where(function ($query) {
                $query->whereNull('vip')
                    ->orWhere('vip', '!=', 1)
                    ->orWhereNull('vip_expires_at')
                    ->orWhere('vip_expires_at', '<=', now());
            })
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
        $promotionDefersSuspension = $baseDeadline
            && $property->isPromotionActive()
            && $property->vip_expires_at->greaterThan($baseDeadline);
        $effectiveDeadline = $promotionDefersSuspension
            ? $property->vip_expires_at->copy()
            : $baseDeadline;

        $property->setAttribute('auto_suspension_days', self::ACTIVE_LIFETIME_DAYS);
        $property->setAttribute('auto_suspension_at', $effectiveDeadline);
        $property->setAttribute('auto_suspension_deferred_by_promotion', $promotionDefersSuspension);
        $property->setAttribute('auto_suspension_remaining', $this->remainingText($effectiveDeadline));
        $property->setAttribute('was_auto_suspended', $property->auto_suspended_at !== null);

        return $property;
    }

    private function remainingText(?CarbonInterface $deadline): ?string
    {
        if (!$deadline) {
            return null;
        }

        $remainingSeconds = now()->diffInSeconds($deadline, false);

        if ($remainingSeconds <= 0) {
            return 'حان موعد التعليق';
        }

        $days = intdiv($remainingSeconds, 86400);
        $hours = intdiv($remainingSeconds % 86400, 3600);
        $minutes = intdiv($remainingSeconds % 3600, 60);

        return "{$days} يوم و{$hours} ساعة و{$minutes} دقيقة";
    }
}
