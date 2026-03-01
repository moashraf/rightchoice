<?php

namespace App\Enums;

class UserStatusEnum
{
    const ACTIVE = 'نشط';
    const UNACTIVE = 'قيد التفعيل';
    const  BLOCK = 'محظور';

    public static function values(): array
    {
        return [
            'نشط' => 1,
            'قيد التفعيل' => 0,
            'محظور ' => 2,
        ];
    }

}
