<?php

namespace App\Enums;

class WhatsappSendTypeEnum
{
    const ALL_USERS      = 'all_users';
    const SELECTED_USERS = 'selected_users';

    public static function all(): array
    {
        return [
            self::ALL_USERS,
            self::SELECTED_USERS,
        ];
    }

    public static function labels(): array
    {
        return [
            self::ALL_USERS      => 'جميع المستخدمين',
            self::SELECTED_USERS => 'مستخدمين محددين',
        ];
    }

    public static function label(string $type): string
    {
        return self::labels()[$type] ?? $type;
    }
}
