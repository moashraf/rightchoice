<?php

namespace App\Services\Whatsapp;

class WhatsappMessagePersonalizer
{
    public const PLACEHOLDERS = [
        '{name}' => 'اسم المستخدم',
    ];

    public static function personalize(string $template, array $userData): string
    {
        $replacements = self::buildReplacements($userData);
        return str_replace(array_keys($replacements), array_values($replacements), $template);
    }

    private static function buildReplacements(array $userData): array
    {
        return [
            '{name}' => $userData['name'] ?? '',
        ];
    }

    public static function preview(string $template, string $sampleName = 'محمد'): string
    {
        return self::personalize($template, ['name' => $sampleName]);
    }
}
