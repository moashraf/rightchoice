<?php

namespace App\Services\Sms;

use InvalidArgumentException;

/**
 * Phone number validation and normalization for Egyptian mobile numbers.
 *
 * Validates format, strips prefixes, and normalizes to the local 01XXXXXXXXX format.
 * Supported operators: Vodafone (010), Etisalat (011), Orange (012), WE (015).
 */
class PhoneValidator
{
    /**
     * Egyptian mobile number regex: 01[0125] followed by 8 digits.
     */
    private const EGYPTIAN_MOBILE_REGEX = '/^01[0125][0-9]{8}$/';

    /**
     * Validate and normalize a phone number.
     *
     * @param string|null $phone Raw phone number
     * @return array{valid: bool, normalized: string|null, reason: string|null}
     */
    public static function validate(?string $phone): array
    {
        // Check for empty/null
        if (empty($phone) || trim($phone) === '') {
            return [
                'valid'      => false,
                'normalized' => null,
                'reason'     => 'رقم الهاتف فارغ أو غير موجود',
            ];
        }

        $normalized = self::normalize($phone);

        // Check normalized format
        if (!preg_match(self::EGYPTIAN_MOBILE_REGEX, $normalized)) {
            return [
                'valid'      => false,
                'normalized' => $normalized,
                'reason'     => 'صيغة رقم الهاتف غير صحيحة: ' . $phone,
            ];
        }

        return [
            'valid'      => true,
            'normalized' => $normalized,
            'reason'     => null,
        ];
    }

    /**
     * Normalize a phone number by stripping spaces, dashes, country codes, etc.
     *
     * @param string $phone Raw phone string
     * @return string Cleaned phone number
     */
    public static function normalize(string $phone): string
    {
        // Remove all non-digit characters
        $cleaned = preg_replace('/\D+/', '', trim($phone));

        // Remove +20 or 0020 international prefix → convert to local 0XX
        if (str_starts_with($cleaned, '002')) {
            $cleaned = '0' . substr($cleaned, 3);
        } elseif (str_starts_with($cleaned, '20') && strlen($cleaned) === 12) {
            $cleaned = '0' . substr($cleaned, 2);
        }

        return $cleaned;
    }

    /**
     * Quick check: is this a valid Egyptian mobile number? (boolean shorthand)
     */
    public static function isValid(?string $phone): bool
    {
        return self::validate($phone)['valid'];
    }
}
