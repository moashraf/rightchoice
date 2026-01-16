<?php

namespace App\Enums;

class StatusEnum
{
    const WAITACTIVE = 'معلق';
    const ACTIVE = 'نشط';
    const UNACTIVE = 'متوقف';

    public static function values(): array
    {
        return [
            'معلق' => 0,
            'نشط' => 1,
            'متوقف' => 2,
        ];
    }

}
