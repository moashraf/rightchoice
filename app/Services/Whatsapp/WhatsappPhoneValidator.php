<?php

namespace App\Services\Whatsapp;

class WhatsappPhoneValidator
{
    private const EGYPTIAN_MOBILE_REGEX = '/^01[0125][0-9]{8}$/';

    public static function validate(?string $phone): array
    {
        if (empty($phone) || trim($phone) === '') {
            return ['valid' => false, 'normalized' => null, 'reason' => 'رقم الهاتف فارغ أو غير موجود'];
        }

        $normalized = self::normalize($phone);

        if (!preg_match(self::EGYPTIAN_MOBILE_REGEX, $normalized)) {
            return ['valid' => false, 'normalized' => $normalized, 'reason' => 'صيغة رقم الهاتف غير صحيحة: ' . $phone];
        }

        return ['valid' => true, 'normalized' => $normalized, 'reason' => null];
    }

    public static function normalize(string $phone): string
    {
        $cleaned = preg_replace('/\D+/', '', trim($phone));

        if (str_starts_with($cleaned, '002')) {
            $cleaned = '0' . substr($cleaned, 3);
        } elseif (str_starts_with($cleaned, '20') && strlen($cleaned) === 12) {
            $cleaned = '0' . substr($cleaned, 2);
        }

        return $cleaned;
    }

    /**
     * Convert a local Egyptian number to international WhatsApp format (+20XXXXXXXXX).
     */
    public static function toInternational(string $normalizedPhone): string
    {
        if (str_starts_with($normalizedPhone, '0')) {
            return '+2' . $normalizedPhone;
        }

        return '+20' . $normalizedPhone;
    }

    public static function isValid(?string $phone): bool
    {
        return self::validate($phone)['valid'];
    }
}
