<?php

namespace App\Services\Sms;

/**
 * Message personalizer – replaces placeholders in an SMS template with user data.
 *
 * Supported placeholders:
 *   {name}  – The user's display name
 *
 * Easily extensible: add new placeholders to the buildReplacements() method.
 */
class MessagePersonalizer
{
    /**
     * All supported placeholders with descriptions (for display in UI).
     */
    public const PLACEHOLDERS = [
        '{name}' => 'اسم المستخدم',
    ];

    /**
     * Replace all supported placeholders in the template with actual user data.
     *
     * @param string $template  The raw message template (e.g. "اهلا {name}")
     * @param array  $userData  Associative array with keys matching placeholder names
     *                          Example: ['name' => 'محمد']
     * @return string The personalized message
     */
    public static function personalize(string $template, array $userData): string
    {
        $replacements = self::buildReplacements($userData);

        return str_replace(
            array_keys($replacements),
            array_values($replacements),
            $template
        );
    }

    /**
     * Build the placeholder → value mapping from user data.
     *
     * @param array $userData User fields
     * @return array<string, string> placeholder => value
     */
    private static function buildReplacements(array $userData): array
    {
        return [
            '{name}' => $userData['name'] ?? '',
        ];
    }

    /**
     * Get a preview of the message for a sample user name (for UI display).
     */
    public static function preview(string $template, string $sampleName = 'محمد'): string
    {
        return self::personalize($template, ['name' => $sampleName]);
    }
}
