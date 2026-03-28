<?php

namespace App\Enums;

/**
 * Refund lifecycle statuses.
 */
class RefundStatusEnum
{
    public const REQUESTED    = 'requested';
    public const UNDER_REVIEW = 'under_review';
    public const APPROVED     = 'approved';
    public const REJECTED     = 'rejected';
    public const REFUNDED     = 'refunded';

    public static function labels(): array
    {
        return [
            self::REQUESTED    => 'تم تقديم الطلب',
            self::UNDER_REVIEW => 'قيد المراجعة',
            self::APPROVED     => 'تمت الموافقة',
            self::REJECTED     => 'مرفوض',
            self::REFUNDED     => 'تم الاسترداد',
        ];
    }

    public static function label(string $status): string
    {
        return self::labels()[$status] ?? $status;
    }

    public static function badge(string $status): string
    {
        return match ($status) {
            self::REFUNDED  => 'success',
            self::APPROVED  => 'info',
            self::UNDER_REVIEW, self::REQUESTED => 'warning',
            self::REJECTED  => 'danger',
            default         => 'secondary',
        };
    }

    public static function all(): array
    {
        return [
            self::REQUESTED, self::UNDER_REVIEW,
            self::APPROVED, self::REJECTED, self::REFUNDED,
        ];
    }
}
