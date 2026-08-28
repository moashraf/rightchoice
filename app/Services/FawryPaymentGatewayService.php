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
        $active             = $this->activeConfig();
        $this->merchantCode = (string) ($active['merchant_code'] ?? '');
        $this->secureKey    = (string) ($active['secure_key'] ?? '');
        $this->statusUrl    = (string) ($active['status_url'] ?? '');
    }

    public function isStaging(): bool
    {
        return (string) config('services.fawry.env') !== 'production';
    }

    public function pluginJs(): string
    {
        return (string) ($this->activeConfig()['plugin_js'] ?? '');
    }

    public function pluginCss(): string
    {
        return (string) ($this->activeConfig()['plugin_css'] ?? '');
    }

    public function chargeUrl(): string
    {
        return (string) ($this->activeConfig()['charge_url'] ?? '');
    }

    private function activeConfig(): array
    {
        if ($this->isStaging()) {
            return (array) config('services.fawry.staging', []);
        }

        return [
            'merchant_code' => config('services.fawry.merchant_code'),
            'secure_key'    => config('services.fawry.secure_key'),
            'charge_url'    => config('services.fawry.charge_url'),
            'status_url'    => config('services.fawry.status_url'),
            'plugin_js'     => config('services.fawry.plugin_js'),
            'plugin_css'    => config('services.fawry.plugin_css'),
        ];
    }

    public function merchantCode(): string
    {
        return $this->merchantCode;
    }

    /**
     * FawryPay JS plugin signature:
     * SHA256(merchantCode + merchantRefNum + customerProfileId + returnUrl + itemId + quantity + price + secureKey)
     */
    public function buildPluginSignature(
        string $merchantRefNum,
        string $customerProfileId,
        string $returnUrl,
        string $itemId,
        int $quantity,
        string $price
    ): string {
        return hash(
            'sha256',
            $this->merchantCode
            . $merchantRefNum
            . $customerProfileId
            . $returnUrl
            . $itemId
            . $quantity
            . $price
            . $this->secureKey
        );
    }

    public function buildPayAtFawrySignature(string $merchantRefNum, string $customerProfileId, string $amount): string
    {
        return hash(
            'sha256',
            $this->merchantCode . $merchantRefNum . $customerProfileId . 'PAYATFAWRY' . $amount . $this->secureKey
        );
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

