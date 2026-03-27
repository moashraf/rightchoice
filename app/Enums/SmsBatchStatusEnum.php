<?php

namespace App\Enums;

/**
 * Overall batch status constants.
 *
 * Tracks the lifecycle of an entire SMS batch/campaign.
 */
class SmsBatchStatusEnum
{
    const PENDING                  = 'pending';
    const PROCESSING               = 'processing';
    const COMPLETED                = 'completed';
    const COMPLETED_WITH_FAILURES  = 'completed_with_failures';
    const FAILED                   = 'failed';

    public static function all(): array
    {
        return [
            self::PENDING,
            self::PROCESSING,
            self::COMPLETED,
            self::COMPLETED_WITH_FAILURES,
            self::FAILED,
        ];
    }

    /**
     * Arabic labels for display.
     */
    public static function labels(): array
    {
        return [
            self::PENDING                 => 'قيد الانتظار',
            self::PROCESSING              => 'جاري المعالجة',
            self::COMPLETED               => 'مكتمل',
            self::COMPLETED_WITH_FAILURES => 'مكتمل مع أخطاء',
            self::FAILED                  => 'فشل',
        ];
    }

    public static function label(string $status): string
    {
        return self::labels()[$status] ?? $status;
    }

    public static function badgeClass(string $status): string
    {
        return match ($status) {
            self::PENDING                 => 'badge-secondary',
            self::PROCESSING              => 'badge-primary',
            self::COMPLETED               => 'badge-success',
            self::COMPLETED_WITH_FAILURES => 'badge-warning',
            self::FAILED                  => 'badge-danger',
            default                       => 'badge-secondary',
        };
    }
}
