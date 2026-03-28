<?php

namespace App\Services\Whatsapp;

class WhatsappSendResult
{
    public function __construct(
        public readonly bool    $success,
        public readonly ?string $messageId = null,
        public readonly ?string $rawResponse = null,
        public readonly ?string $failureReason = null,
    ) {}

    public static function success(?string $messageId = null, ?string $rawResponse = null): self
    {
        return new self(success: true, messageId: $messageId, rawResponse: $rawResponse);
    }

    public static function failure(string $reason, ?string $rawResponse = null): self
    {
        return new self(success: false, failureReason: $reason, rawResponse: $rawResponse);
    }
}
