<?php

namespace App\Enums;

class WhatsappSendStatusEnum
{
    const PENDING        = 'pending';
    const QUEUED         = 'queued';
    const SENDING        = 'sending';
    const SENT           = 'sent';
    const DELIVERED      = 'delivered';
    const FAILED         = 'failed';
    const INVALID_NUMBER = 'invalid_number';

    public static function all(): array
    {
        return [
            self::PENDING,
            self::QUEUED,
            self::SENDING,
            self::SENT,
            self::DELIVERED,
            self::FAILED,
            self::INVALID_NUMBER,
        ];
    }

    public static function labels(): array
    {
        return [
            self::PENDING        => 'قيد الانتظار',
            self::QUEUED         => 'في قائمة الانتظار',
            self::SENDING        => 'جاري الإرسال',
            self::SENT           => 'تم الإرسال',
            self::DELIVERED      => 'تم التسليم',
            self::FAILED         => 'فشل الإرسال',
            self::INVALID_NUMBER => 'رقم غير صالح',
        ];
    }

    public static function badgeClass(string $status): string
    {
        return match ($status) {
            self::PENDING        => 'badge-secondary',
            self::QUEUED         => 'badge-info',
            self::SENDING        => 'badge-primary',
            self::SENT           => 'badge-success',
            self::DELIVERED      => 'badge-success',
            self::FAILED         => 'badge-danger',
            self::INVALID_NUMBER => 'badge-warning',
            default              => 'badge-secondary',
        };
    }

    public static function label(string $status): string
    {
        return self::labels()[$status] ?? $status;
    }
}
