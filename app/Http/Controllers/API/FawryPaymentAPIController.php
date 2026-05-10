<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\AppBaseController;
use App\Models\FawryPayment;
use App\Models\Pricing;
use App\Models\UserPriceing;
use App\Models\aqar;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

/**
 * Fawry Payment API Controller
 *
 * Endpoints:
 *   POST /api/fawry/charge          → إنشاء طلب دفع بفوري (PAYATFAWRY)
 *   GET  /api/fawry/callback        → callback بعد الدفع (اشتراك باقة)
 *   GET  /api/fawry/vip-callback    → callback بعد الدفع (تمييز إعلان)
 */
class FawryPaymentAPIController extends AppBaseController
{
    // ── Fawry Credentials ────────────────────────────────────────────────────
    private string $merchantCode   = 'TUDH+sU93QqTh4bRQqAadQ==';
    private string $merchantSecKey = '160224c0e40347318144da5efa284eda';
    private string $fawryUrl       = 'https://www.atfawry.com/ECommerceWeb/Fawry/payments/charge';

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Build the Fawry PAYATFAWRY signature (SHA-256).
     */
    private function buildSignature(string $amount, string $merchantRefNum, $customerProfileId): string
    {
        return hash(
            'SHA256',
            $this->merchantCode . $merchantRefNum . $customerProfileId . 'PAYATFAWRY' . $amount . $this->merchantSecKey
        );
    }

    /**
     * Build the chargeItems array required by Fawry.
     */
    private function buildChargeItems(string $amount): array
    {
        return [[
            'itemId'      => 4365,
            'description' => 'Subscription Package',
            'price'       => $amount,
            'quantity'    => 1,
        ]];
    }

    // ─────────────────────────────────────────────────────────────────────────
    // POST /api/fawry/charge
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * إنشاء طلب دفع عن طريق فوري.
     *
     * Body Parameters:
     *   - price_id   (required) : ID الباقة المطلوب الاشتراك فيها
     *   - price      (required) : المبلغ بالجنيه المصري
     *   - aqar_id    (optional) : في حالة تمييز إعلان
     *
     * Returns:
     *   - referenceNumber : رقم المرجع اللي هيتم الدفع بيه عند منافذ فوري
     *   - customerMobile  : رقم موبايل العميل
     *   - amount          : المبلغ
     *   - paymentMethod   : PAYATFAWRY
     */
    public function charge(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'price_id' => 'required|integer',
            'price'    => 'required|numeric|min:1',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error', $validator->errors(), 422);
        }

        $user           = $request->user();
        $merchantRefNum = random_int(100000, 999999);
        $amount         = number_format((float) $request->price, 2, '.', '');

        $data = [
            'merchantCode'      => $this->merchantCode,
            'merchantRefNum'    => $merchantRefNum,
            'customerProfileId' => $user->id,
            'customerMobile'    => $user->MOP ?? '01000000000',
            'customerEmail'     => $user->email,
            'paymentMethod'     => 'PAYATFAWRY',
            'amount'            => $amount,
            'currencyCode'      => 'EGP',
            'description'       => 'Subscription purchase via Fawry',
            'chargeItems'       => $this->buildChargeItems($amount),
            'signature'         => $this->buildSignature($amount, $merchantRefNum, $user->id),
        ];

        try {
            $client     = new \GuzzleHttp\Client();
            $apiRequest = $client->request('POST', $this->fawryUrl, [
                'headers' => [
                    'Accept'       => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'json' => $data,
            ]);

            $response = json_decode($apiRequest->getBody()->getContents(), true);

            $referenceNumber = $response['referenceNumber'] ?? null;
            $customerMobile  = $response['customerMobile']  ?? $user->MOP ?? 'N/A';

            // حفظ سجل الدفع
            $payment = FawryPayment::create([
                'paymentAmount'          => $amount,
                'user_id'                => $user->id,
                'paymentStatus'          => 'UNPAID',
                'paymentMethod'          => 'PAYATFAWRY',
                'signature'              => $this->buildSignature($amount, $merchantRefNum, $user->id),
                'referenceNumber'        => $referenceNumber,
                'merchantRefNumber'      => $merchantRefNum,
                'paqaat_priceing_sale_id'=> $request->price_id,
            ]);

            return $this->sendResponse([
                'referenceNumber' => $referenceNumber,
                'customerMobile'  => $customerMobile,
                'amount'          => $amount,
                'paymentMethod'   => 'PAYATFAWRY',
                'payment_id'      => $payment->id,
                'message'         => "استخدم الكود $referenceNumber وانت بتدفع في أي منفذ من منافذ فوري. المبلغ المطلوب: $amount جنيه.",
            ], 'تم إنشاء طلب الدفع بنجاح');

        } catch (\Exception $e) {
            Log::error('Fawry charge error: ' . $e->getMessage());
            return $this->sendError('فشل الاتصال بخدمة فوري', ['error' => $e->getMessage()], 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/fawry/callback   (اشتراك باقة)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Callback من فوري بعد الدفع — تفعيل اشتراك باقة للمستخدم.
     *
     * Query Parameters (من فوري):
     *   - orderStatus       : PAID | UNPAID | ...
     *   - customerProfileId : {pricing_id}55555{user_id}
     *   - referenceNumber   : رقم مرجع الدفع
     */
    public function fawryCallback(Request $request): JsonResponse
    {
        $orderStatus = $request->query('orderStatus');

        if ($orderStatus !== 'PAID') {
            return $this->sendError('الدفع لم يكتمل', ['orderStatus' => $orderStatus], 400);
        }

        $customerProfileId = $request->query('customerProfileId');
        if (!$customerProfileId) {
            return $this->sendError('بيانات غير مكتملة', [], 400);
        }

        // customerProfileId = {pricing_id}55555{user_id}
        $pieces  = explode('55555', $customerProfileId);
        $pricId  = $pieces[0] ?? null;
        $userId  = $pieces[1] ?? null;

        $pric = Pricing::find($pricId);
        if (!$pric) {
            return $this->sendError('الباقة غير موجودة', [], 404);
        }

        // إلغاء الاشتراك الحالي وحساب النقاط المتبقية
        $current      = 0;
        $checkPricing = UserPriceing::where('user_id', $userId)->where('statues', 1)->orderByDesc('id')->first();

        if ($checkPricing) {
            $checkPricing->update(['statues' => 0]);
            if ($checkPricing->current_points >= 0) {
                $current = $checkPricing->current_points;
            }
        }

        // إنشاء الاشتراك الجديد
        UserPriceing::create([
            'user_id'        => $userId,
            'pricing_id'     => $pric->id,
            'statues'        => 1,
            'start_points'   => $pric->points,
            'current_points' => $pric->points + $current,
            'sub_points'     => 0,
        ]);

        // تحديث حالة الدفع
        $referenceNumber = $request->query('referenceNumber');
        if ($referenceNumber) {
            FawryPayment::where('referenceNumber', $referenceNumber)
                ->update(['paymentStatus' => 'PAID', 'paid_at' => now()]);
        }

        return $this->sendResponse([
            'points'  => $pric->points + $current,
            'message' => "ربحت معنا {$pric->points} نقطة! ممكن تتعامل مع المالك مباشرة بدون عمولة.",
        ], 'تم تفعيل الاشتراك بنجاح');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/fawry/vip-callback   (تمييز إعلان)
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Callback من فوري بعد الدفع — تمييز إعلان (VIP).
     *
     * Query Parameters (من فوري):
     *   - orderStatus       : PAID | UNPAID | ...
     *   - customerProfileId : {pricing_id}55555{aqar_id}
     *   - referenceNumber   : رقم مرجع الدفع
     */
    public function tmyezzFawryCallback(Request $request): JsonResponse
    {
        $orderStatus = $request->query('orderStatus');

        if ($orderStatus !== 'PAID') {
            return $this->sendError('الدفع لم يكتمل', ['orderStatus' => $orderStatus], 400);
        }

        $customerProfileId = $request->query('customerProfileId');
        if (!$customerProfileId) {
            return $this->sendError('بيانات غير مكتملة', [], 400);
        }

        // customerProfileId = {pricing_id}55555{aqar_id}
        $pieces = explode('55555', $customerProfileId);
        $aqarId = $pieces[1] ?? null;

        $aqar = aqar::find($aqarId);
        if (!$aqar) {
            return $this->sendError('الإعلان غير موجود', [], 404);
        }

        $aqar->vip = 1;
        $aqar->save();

        // تحديث حالة الدفع
        $referenceNumber = $request->query('referenceNumber');
        if ($referenceNumber) {
            FawryPayment::where('referenceNumber', $referenceNumber)
                ->update(['paymentStatus' => 'PAID', 'paid_at' => now()]);
        }

        return $this->sendResponse([
            'aqar_id' => $aqar->id,
            'vip'     => true,
        ], 'تم تمييز إعلانك بنجاح');
    }
}

