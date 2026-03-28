<?php

namespace App\Services\Sms;

/**
 * Value object representing the result of a single SMS send attempt.
 *
 * Encapsulates whether the send succeeded, the provider's message ID,
 * raw response, and failure reason.
 */
class SmsSendResult
{
    public function __construct(
        public readonly bool    $success,
        public readonly ?string $messageId = null,
        public readonly ?string $rawResponse = null,
        public readonly ?string $failureReason = null,
    ) {}

    /**
     * Create a successful result.
     */
    public static function success(?string $messageId = null, ?string $rawResponse = null): self
    {
        return new self(
            success: true,
            messageId: $messageId,
            rawResponse: $rawResponse,
        );
    }

    /**
     * Create a failed result.
     */
    public static function failure(string $reason, ?string $rawResponse = null): self
    {
        return new self(
            success: false,
            failureReason: $reason,
            rawResponse: $rawResponse,
        );
    }
}
