<?php

namespace App\Services\Sms\Providers;

use App\Contracts\SmsProviderInterface;
use App\Services\Sms\SmsSendResult;

/**
 * Vodafone Web2SMS provider adapter.
 *
 * Integrates with the Vodafone Egypt e3len web2sms API.
 * Credentials are loaded from config('sms.providers.vodafone').
 */
class VodafoneSmsProvider implements SmsProviderInterface
{
    private string $accountId;
    private string $password;
    private string $senderName;
    private string $secretCode;
    private string $url;

    public function __construct()
    {
        $config = config('sms.providers.vodafone');

        $this->accountId  = $config['account_id'];
        $this->password   = $config['password'];
        $this->senderName = $config['sender_name'];
        $this->secretCode = $config['secret_code'];
        $this->url        = $config['url'];
    }

    public function getName(): string
    {
        return 'vodafone';
    }

    /**
     * Send an SMS via Vodafone Web2SMS API.
     */
    public function send(string $mobile, string $message): SmsSendResult
    {
        // Build the signature hash
        $stringValue = "AccountId={$this->accountId}&Password={$this->password}"
                     . "&SenderName={$this->senderName}&ReceiverMSISDN={$mobile}"
                     . "&SMSText={$message}";
        $signature = strtoupper(hash_hmac('sha256', $stringValue, $this->secretCode));

        // Build XML request body
        $xmlBody = "<?xml version='1.0' encoding='UTF-8'?>"
            . "<SubmitSMSRequest xmlns:='http://www.edafa.com/web2sms/sms/model/' "
            . "xmlns:xsi='http://www.w3.org/2001/XMLSchemainstance' "
            . "xsi:schemaLocation='http://www.edafa.com/web2sms/sms/model/ SMSAPI.xsd ' "
            . "xsi:type='SubmitSMSRequest'>"
            . "<AccountId>{$this->accountId}</AccountId>"
            . "<Password>{$this->password}</Password>"
            . "<SecureHash>{$signature}</SecureHash>"
            . "<SMSList>"
            . "<SenderName>{$this->senderName}</SenderName>"
            . "<ReceiverMSISDN>{$mobile}</ReceiverMSISDN>"
            . "<SMSText>{$message}</SMSText>"
            . "</SMSList>"
            . "</SubmitSMSRequest>";

        try {
            $curl = curl_init($this->url);
            curl_setopt_array($curl, [
                CURLOPT_URL            => $this->url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER     => [
                    'Accept: application/xml',
                    'Content-Type: application/xml',
                ],
                CURLOPT_SSL_VERIFYHOST => 2,
                CURLOPT_SSL_VERIFYPEER => true,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => $xmlBody,
                CURLOPT_TIMEOUT        => 30,
                CURLOPT_CONNECTTIMEOUT => 10,
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $curlError = curl_error($curl);
            curl_close($curl);

            // cURL-level failure
            if ($response === false) {
                return SmsSendResult::failure(
                    "cURL error: {$curlError}",
                    null
                );
            }

            // HTTP error
            if ($httpCode < 200 || $httpCode >= 300) {
                return SmsSendResult::failure(
                    "HTTP {$httpCode} error from Vodafone API",
                    $response
                );
            }

            // Try to extract message ID from XML response
            $messageId = $this->extractMessageId($response);

            return SmsSendResult::success($messageId, $response);

        } catch (\Throwable $e) {
            return SmsSendResult::failure(
                "Exception: {$e->getMessage()}",
                null
            );
        }
    }

    /**
     * Attempt to parse the message ID from the Vodafone XML response.
     */
    private function extractMessageId(string $xml): ?string
    {
        try {
            $parsed = @simplexml_load_string($xml);
            if ($parsed && isset($parsed->MessageId)) {
                return (string) $parsed->MessageId;
            }
        } catch (\Throwable $e) {
            // Ignore parse errors
        }
        return null;
    }
}
