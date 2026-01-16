<?php

namespace App\Enums;

class UserStatusEnum
{
    const ACTIVE = 'نشط';
    const UNACTIVE = 'متوقف';

    public static function values(): array
    {
        return [
            'نشط' => 1,
            'متوقف' => 0,
        ];
    }

}
