<?php

namespace App\Services\Whatsapp\Providers;

use App\Contracts\WhatsappProviderInterface;
use App\Services\Whatsapp\WhatsappSendResult;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class UltraMsgWhatsappProvider implements WhatsappProviderInterface
{
    private string $instanceId;
    private string $token;
    private string $baseUrl;

    public function __construct()
    {
        $this->instanceId = config('whatsapp.providers.ultramsg.instance_id', '');
        $this->token      = config('whatsapp.providers.ultramsg.token', '');
        $this->baseUrl     = "https://api.ultramsg.com/{$this->instanceId}";
    }

    public function getName(): string
    {
        return 'ultramsg';
    }

    public function send(string $mobile, string $message): WhatsappSendResult
    {
        if (empty($this->instanceId) || empty($this->token)) {
            Log::error('[UltraMsgWhatsappProvider] Missing instance_id or token in config.');
            return WhatsappSendResult::failure('UltraMsg configuration missing (instance_id or token).');
        }

        // تحويل الرقم للصيغة الدولية إن مكانش كده
        $international = $this->toInternational($mobile);

        try {
            $response = Http::asForm()
                ->timeout(30)
                ->post("{$this->baseUrl}/messages/chat", [
                    'token' => $this->token,
                    'to'    => $international,
                    'body'  => $message,
                ]);

            $body = $response->json();

            Log::info('[UltraMsgWhatsappProvider] Response', [
                'mobile'   => $international,
                'status'   => $response->status(),
                'response' => $body,
            ]);

            // UltraMsg returns {"sent":"true","message":"ok","id":"..."} on success
            if ($response->successful() && isset($body['sent']) && $body['sent'] === 'true') {
                return WhatsappSendResult::success(
                    $body['id'] ?? null,
                    json_encode($body)
                );
            }

            $errorMessage = $body['message'] ?? $body['error'] ?? 'Unknown UltraMsg error';
            return WhatsappSendResult::failure($errorMessage, json_encode($body));

        } catch (\Exception $e) {
            Log::error('[UltraMsgWhatsappProvider] Exception', [
                'mobile'  => $international,
                'error'   => $e->getMessage(),
            ]);
            return WhatsappSendResult::failure('UltraMsg API error: ' . $e->getMessage());
        }
    }

    /**
     * Convert Egyptian mobile to international format (+20XXXXXXXXX).
     */
    private function toInternational(string $mobile): string
    {
        $mobile = preg_replace('/[^0-9]/', '', $mobile);

        // Already international with country code
        if (str_starts_with($mobile, '20') && strlen($mobile) === 12) {
            return '+' . $mobile;
        }

        // Local format: 01XXXXXXXXX
        if (str_starts_with($mobile, '0') && strlen($mobile) === 11) {
            return '+2' . $mobile;
        }

        // Fallback: just add + prefix
        return '+' . $mobile;
    }
}
