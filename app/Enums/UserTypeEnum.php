<?php

namespace App\Enums;

final class UserTypeEnum
{
    const Buyer = 'مشتري او مستأجر';
    const SALER = 'بائع او مؤجر';
    const DEVELOPER = 'مطور عقاري';
    const COMPANY = 'شركة';

    public static function values(): array
    {
        return [
            'مشتري او مستأجر' => 1,
            'بائع او مؤجر' => 2,
            'مطور عقاري' => 3,
            'شركة' => 4,
        ];
    }

}
