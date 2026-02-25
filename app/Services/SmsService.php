<?php

namespace App\Services;

class SmsService
{
    /**
     * Send OTP verification SMS via Vodafone web2sms API.
     *
     * @param string $phoneNumber  The recipient phone number (MOP)
     * @param int    $otpCode      The OTP verification code
     * @return string|false        The API response or false on failure
     */
    public static function sendOtp(string $phoneNumber, int $otpCode)
    {
        $url = "https://e3len.vodafone.com.eg/web2sms/sms/submit/";

        $accountId  = '200002798';
        $password   = 'Vodafone.1';
        $senderName = 'RightChoice';
        $secretCode = 'D8FBFDD3DD684C85BC00E708FC5872EB';
        $smsText    = "$otpCode is your verification code for RightChoice";

        $stringValue = "AccountId=$accountId&Password=$password&SenderName=$senderName&ReceiverMSISDN=$phoneNumber&SMSText=$smsText";
        $sig = strtoupper(hash_hmac('sha256', $stringValue, $secretCode));

        $xmlBody = "<?xml version='1.0' encoding='UTF-8'?>
<SubmitSMSRequest xmlns:='http://www.edafa.com/web2sms/sms/model/' xmlns:xsi='http://www.w3.org/2001/XMLSchemainstance' xsi:schemaLocation='http://www.edafa.com/web2sms/sms/model/ SMSAPI.xsd ' xsi:type='SubmitSMSRequest'>
<AccountId>$accountId</AccountId>
<Password>$password</Password>
<SecureHash>$sig</SecureHash>
<SMSList>
<SenderName>$senderName</SenderName>
<ReceiverMSISDN>$phoneNumber</ReceiverMSISDN>
<SMSText>$smsText</SMSText>
</SMSList>
</SubmitSMSRequest>";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Accept: application/xml",
            "Content-Type: application/xml",
        ]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($curl, CURLOPT_POSTFIELDS, $xmlBody);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;
    }
}
