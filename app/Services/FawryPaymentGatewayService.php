<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Models\FawryPayment;
use GuzzleHttp\Client;
use RuntimeException;

class FawryPaymentGatewayService
{
    private Client $client;
    private string $merchantCode;
    private string $secureKey;
    private string $statusUrl;

    public function __construct()
    {
        $this->client       = new Client(['timeout' => 20, 'connect_timeout' => 10]);
        $this->merchantCode = (string) config('services.fawry.merchant_code');
        $this->secureKey    = (string) config('services.fawry.secure_key');
        $this->statusUrl    = (string) config('services.fawry.status_url');
    }

    public function checkPaymentStatus($payment): array
    {
        if (!$payment instanceof FawryPayment) {
            throw new RuntimeException('نوع عملية الدفع غير مدعوم للتحقق من فوري.');
        }

        if (empty($payment->merchantRefNumber)) {
            throw new RuntimeException('لا يوجد رقم مرجع تاجر لهذه العملية.');
        }

        $merchantRefNumber = (string) $payment->merchantRefNumber;

        $signature = hash(
            'sha256',
            $this->merchantCode . $merchantRefNumber . $this->secureKey
        );

        // مهم: لا تستخدم query array هنا لأن Guzzle هيعمل encode للـ + و =
        $statusUrl = $this->statusUrl
            . '?merchantCode=' . $this->merchantCode
            . '&merchantRefNumber=' . $merchantRefNumber
            . '&signature=' . $signature;

        $response = $this->client->request('GET', $statusUrl, [
            'headers' => [
                'Accept' => 'application/json',
            ],
        ]);

        $rawBody = $response->getBody()->getContents();
        $rawResponse = json_decode($rawBody, true);
dd($rawResponse);
        if (!is_array($rawResponse)) {
            throw new RuntimeException('رد فوري غير صالح أو غير قابل للقراءة.');
        }

        $status = $rawResponse['paymentStatus'] ?? $rawResponse['orderStatus'] ?? null;

        return [
            'merchant_ref_number' => $merchantRefNumber,
            'status'              => $status ? $this->normalizeStatus((string) $status) : null,
            'raw_status'          => $status,
            'raw_response'        => $rawResponse,
        ];
    }
    private function normalizeStatus(string $status): string
    {
        $status = strtoupper($status);

        return match ($status) {
            'CANCELED' => PaymentStatusEnum::CANCELLED,
            default    => $status,
        };
    }
}

