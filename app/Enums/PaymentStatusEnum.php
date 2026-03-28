<?php

namespace App\Enums;

/**
 * Payment lifecycle statuses.
 * Maps to the fawryPayment.paymentStatus column.
 */
class PaymentStatusEnum
{
    public const INITIATED = 'INITIATED';
    public const PENDING   = 'PENDING';
    public const UNPAID    = 'UNPAID';
    public const PAID      = 'PAID';
    public const FAILED    = 'FAILED';
    public const CANCELLED = 'CANCELLED';
    public const EXPIRED   = 'EXPIRED';

    public static function labels(): array
    {
        return [
            self::INITIATED => 'بدأت العملية',
            self::PENDING   => 'قيد الانتظار',
            self::UNPAID    => 'غير مدفوع',
            self::PAID      => 'مدفوع',
            self::FAILED    => 'فشلت',
            self::CANCELLED => 'ملغاة',
            self::EXPIRED   => 'منتهية الصلاحية',
        ];
    }

    public static function label(string $status): string
    {
        return self::labels()[$status] ?? $status;
    }

    public static function badge(string $status): string
    {
        return match ($status) {
            self::PAID      => 'success',
            self::PENDING, self::UNPAID, self::INITIATED => 'warning',
            self::FAILED    => 'danger',
            self::CANCELLED => 'secondary',
            self::EXPIRED   => 'dark',
            default         => 'info',
        };
    }

    public static function all(): array
    {
        return [
            self::INITIATED, self::PENDING, self::UNPAID,
            self::PAID, self::FAILED, self::CANCELLED, self::EXPIRED,
        ];
    }
}
