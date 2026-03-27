<?php

namespace App\Contracts;

use App\Services\Sms\SmsSendResult;

/**
 * Contract for SMS provider adapters.
 *
 * Any SMS gateway (Vodafone, Twilio, Infobip, etc.) must implement this interface.
 * This allows swapping providers without changing the sending logic.
 */
interface SmsProviderInterface
{
    /**
     * Get the provider's unique name (e.g. 'vodafone', 'twilio', 'mock').
     */
    public function getName(): string;

    /**
     * Send an SMS message to a single recipient.
     *
     * @param string $mobile  Normalized mobile number
     * @param string $message The final (personalized) message text
     * @return SmsSendResult  Result object with success/fail status and details
     */
    public function send(string $mobile, string $message): SmsSendResult;
}
