<?php

namespace App\Http\Controllers;

use App\Models\aqar;
use App\Models\AqarAnalyticsEvent;
use App\Services\AqarAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * نقطة نهاية AJAX لتسجيل الأحداث القادمة من الواجهة (مقارنة، مشاركة، وأي حدث مسموح).
 *
 * يعتمد على AqarAnalyticsService لتوحيد منطق التسجيل. المدخلات مقيدة:
 *  - العقار يجب أن يكون منشورًا.
 *  - نوع الحدث ضمن قائمة مسموحة فقط.
 *  - metadata غير موثوقة تُستبعد تلقائيًا داخل الخدمة.
 *
 * ملاحظات:
 *  - يدعم CSRF عبر مجموعة Web.
 *  - يستخدم navigator.sendBeacon (Content-Type=text/plain) أو fetch العادي.
 *  - محمي بـ Rate Limiting عبر مجموعة الـ route.
 */
class AqarAnalyticsTrackingController extends Controller
{
    /**
     * الأحداث المسموح بإرسالها من الواجهة العامة عبر AJAX.
     * ملاحظة: view, contact_reveal, whatsapp_click, favorite تُسجَّل من الـ Backend
     * لذلك لا نسمح للعميل بإرسالها لتفادي التلاعب.
     */
    protected array $publicAllowedEvents = [
        AqarAnalyticsEvent::EVENT_COMPARISON,
        AqarAnalyticsEvent::EVENT_SHARE,
        AqarAnalyticsEvent::EVENT_WHATSAPP_CLICK,
    ];

    public function store(Request $request, AqarAnalyticsService $service): JsonResponse
    {
        $payload = $this->resolvePayload($request);

        $validator = Validator::make($payload, [
            'aqar_id'    => 'required|integer|exists:aqar,id',
            'event_type' => 'required|string',
            'source'     => 'nullable|string|max:40',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 422,
                'message' => 'بيانات غير صالحة',
                'errors'  => $validator->errors(),
            ], 422);
        }

        $data = $validator->validated();

        if (! in_array($data['event_type'], $this->publicAllowedEvents, true)) {
            return response()->json([
                'status'  => 422,
                'message' => 'نوع الحدث غير مسموح',
            ], 422);
        }

        $aqar = aqar::find($data['aqar_id']);
        if (! $aqar || (int) $aqar->status !== 1) {
            return response()->json([
                'status'  => 404,
                'message' => 'العقار غير متاح',
            ], 404);
        }

        $metadata = [];
        if (! empty($data['source'])) {
            $metadata['source'] = $data['source'];
        }

        $event = match ($data['event_type']) {
            AqarAnalyticsEvent::EVENT_COMPARISON     => $service->trackComparison($aqar, $request, $metadata),
            AqarAnalyticsEvent::EVENT_SHARE          => $service->trackShare($aqar, $request, $metadata),
            AqarAnalyticsEvent::EVENT_WHATSAPP_CLICK => $service->trackWhatsappClick($aqar, $request, $metadata),
            default                                  => null,
        };

        return response()->json([
            'status'  => 200,
            'tracked' => (bool) $event,
        ]);
    }

    /**
     * يقبل الطلب من fetch (JSON) أو navigator.sendBeacon (text/plain body).
     */
    protected function resolvePayload(Request $request): array
    {
        $data = $request->all();
        if (! empty($data)) {
            return $data;
        }
        $raw = (string) $request->getContent();
        if ($raw === '') {
            return [];
        }
        $decoded = json_decode($raw, true);
        return is_array($decoded) ? $decoded : [];
    }
}
