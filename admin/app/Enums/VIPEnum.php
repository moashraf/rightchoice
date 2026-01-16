<?php

namespace App\Enums;

class VIPEnum
{
    const NOTVIP = 'غير مميز';
    const VIP = 'مميز';

    public static function values(): array
    {
        return [
            'مميز' => 1,
            'غير مميز' => 0,
        ];
    }

}
