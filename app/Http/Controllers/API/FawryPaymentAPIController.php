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

    // ── Arabic Validation Messages ────────────────────────────────────────────
    private array $arabicMessages = [
        'required' => 'حقل :attribute مطلوب.',
        'integer'  => 'حقل :attribute يجب أن يكون رقمًا صحيحًا.',
        'numeric'  => 'حقل :attribute يجب أن يكون رقمًا.',
        'min'      => 'حقل :attribute يجب أن يكون على الأقل :min.',
        'max'      => 'حقل :attribute يجب ألا يتجاوز :max.',
        'string'   => 'حقل :attribute يجب أن يكون نصًا.',
        'exists'   => ':attribute غير موجود في النظام.',
        'in'       => 'قيمة :attribute غير صحيحة. القيم المسموحة: :values.',
        'regex'    => 'تنسيق :attribute غير صحيح.',
    ];

    // ─────────────────────────────────────────────────────────────────────────
    // Helpers
    // ─────────────────────────────────────────────────────────────────────────

    private function buildSignature(string $amount, string $merchantRefNum, $customerProfileId): string
    {
        return hash(
            'SHA256',
            $this->merchantCode . $merchantRefNum . $customerProfileId . 'PAYATFAWRY' . $amount . $this->merchantSecKey
        );
    }

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

    public function charge(Request $request): JsonResponse
    {
        // ── Validation ───────────────────────────────────────────────────────
        $validator = Validator::make(
            $request->all(),
            [
                'price_id' => 'required|integer|exists:priceing_sale,id',
                'price'    => 'required|numeric|min:1|max:99999',
            ],
            array_merge($this->arabicMessages, [
                'price_id.exists' => 'الباقة المختارة غير موجودة في النظام.',
                'price.min'       => 'المبلغ يجب أن يكون على الأقل 1 جنيه.',
                'price.max'       => 'المبلغ يجب ألا يتجاوز 99,999 جنيه.',
            ]),
            [
                'price_id' => 'الباقة',
                'price'    => 'المبلغ',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('خطأ في البيانات المدخلة', 422, $validator->errors()->toArray());
        }

        // ── Business Rules ───────────────────────────────────────────────────
        $user = $request->user();

        if (empty($user->email)) {
            return $this->sendError('بيانات المستخدم غير مكتملة', 422, [
                'email' => ['البريد الإلكتروني مطلوب لإتمام عملية الدفع.'],
            ]);
        }

        // التحقق من وجود دفعة معلقة لنفس الباقة
        $pendingPayment = FawryPayment::where('user_id', $user->id)
            ->where('paqaat_priceing_sale_id', $request->price_id)
            ->where('paymentStatus', 'UNPAID')
            ->where('created_at', '>=', now()->subHours(24))
            ->first();

        if ($pendingPayment) {
            return $this->sendError('يوجد طلب دفع معلق', 409, [
                'referenceNumber' => [$pendingPayment->referenceNumber],
                'message'         => ['لديك طلب دفع معلق لنفس الباقة. يمكنك استخدام الكود: ' . $pendingPayment->referenceNumber],
            ]);
        }

        // ── Process ──────────────────────────────────────────────────────────
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

            // التحقق من نجاح رد فوري
            if (isset($response['statusCode']) && $response['statusCode'] != 200) {
                Log::error('Fawry API error response: ' . json_encode($response));
                return $this->sendError('رفضت فوري طلب الدفع', 422, [
                    'fawry_message' => [$response['description'] ?? 'خطأ غير معروف من فوري'],
                    'status_code'   => [$response['statusCode'] ?? null],
                ]);
            }

            $referenceNumber = $response['referenceNumber'] ?? null;
            $customerMobile  = $response['customerMobile']  ?? $user->MOP ?? 'N/A';

            if (!$referenceNumber) {
                return $this->sendError('لم يتم استلام رقم المرجع من فوري', 502, [
                    'fawry_response' => [$response],
                ]);
            }

            $payment = FawryPayment::create([
                'paymentAmount'           => $amount,
                'user_id'                 => $user->id,
                'paymentStatus'           => 'UNPAID',
                'paymentMethod'           => 'PAYATFAWRY',
                'signature'               => $this->buildSignature($amount, $merchantRefNum, $user->id),
                'referenceNumber'         => $referenceNumber,
                'merchantRefNumber'       => $merchantRefNum,
                'paqaat_priceing_sale_id' => $request->price_id,
            ]);

            return $this->sendResponse([
                'referenceNumber' => $referenceNumber,
                'customerMobile'  => $customerMobile,
                'amount'          => $amount,
                'paymentMethod'   => 'PAYATFAWRY',
                'payment_id'      => $payment->id,
                'message'         => "استخدم الكود $referenceNumber وانت بتدفع في أي منفذ من منافذ فوري. المبلغ المطلوب: $amount جنيه.",
            ], 'تم إنشاء طلب الدفع بنجاح');

        } catch (\GuzzleHttp\Exception\ConnectException $e) {
            Log::error('Fawry connection error: ' . $e->getMessage());
            return $this->sendError('تعذر الاتصال بخدمة فوري، حاول مرة أخرى لاحقًا.', 503);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            $body = json_decode($e->getResponse()->getBody()->getContents(), true);
            Log::error('Fawry client error: ' . json_encode($body));
            return $this->sendError('خطأ في بيانات الدفع', 422, [
                'fawry_message' => [$body['description'] ?? $e->getMessage()],
            ]);
        } catch (\Exception $e) {
            Log::error('Fawry charge error: ' . $e->getMessage());
            return $this->sendError('حدث خطأ غير متوقع أثناء معالجة الدفع.', 500);
        }
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/fawry/callback   (اشتراك باقة)
    // ─────────────────────────────────────────────────────────────────────────

    public function fawryCallback(Request $request): JsonResponse
    {
        // ── Validation ───────────────────────────────────────────────────────
        $validator = Validator::make(
            $request->query(),
            [
                'orderStatus'       => 'required|string|in:PAID,UNPAID,EXPIRED,FAILED,CANCELED',
                'customerProfileId' => ['required', 'string', 'regex:/^\d+55555\d+$/'],
                'referenceNumber'   => 'required|string',
                'paymentAmount'     => 'nullable|numeric|min:0',
            ],
            array_merge($this->arabicMessages, [
                'orderStatus.in'           => 'حالة الطلب غير صحيحة. القيم المقبولة: PAID, UNPAID, EXPIRED, FAILED, CANCELED.',
                'customerProfileId.regex'  => 'تنسيق customerProfileId غير صحيح. يجب أن يكون بالشكل: {pricing_id}55555{user_id}.',
                'referenceNumber.required' => 'رقم المرجع (referenceNumber) مطلوب.',
            ]),
            [
                'orderStatus'       => 'حالة الطلب',
                'customerProfileId' => 'معرف العميل',
                'referenceNumber'   => 'رقم المرجع',
                'paymentAmount'     => 'مبلغ الدفع',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('بيانات الـ callback غير صحيحة', 422, $validator->errors()->toArray());
        }

        // ── Check payment status ─────────────────────────────────────────────
        if ($request->query('orderStatus') !== 'PAID') {
            return $this->sendError('الدفع لم يكتمل', 400, [
                'orderStatus' => [$request->query('orderStatus')],
                'message'     => ['لم يتم الدفع بنجاح. حالة الطلب: ' . $request->query('orderStatus')],
            ]);
        }

        // ── Parse customerProfileId ─────────────────────────────────────────
        $pieces = explode('55555', $request->query('customerProfileId'));
        $pricId = $pieces[0] ?? null;
        $userId = $pieces[1] ?? null;

        $pric = Pricing::find($pricId);
        if (!$pric) {
            Log::error("Fawry callback: pricing_id={$pricId} not found");
            return $this->sendError('الباقة غير موجودة', 404, [
                'pricing_id' => ["الباقة رقم {$pricId} غير موجودة في النظام."],
            ]);
        }

        if (!$userId || !is_numeric($userId)) {
            return $this->sendError('معرف المستخدم غير صحيح', 422, [
                'user_id' => ['تعذر تحديد المستخدم من بيانات الدفع.'],
            ]);
        }

        // التحقق من عدم تكرار تفعيل نفس الدفعة
        $referenceNumber  = $request->query('referenceNumber');
        $alreadyProcessed = FawryPayment::where('referenceNumber', $referenceNumber)
            ->where('paymentStatus', 'PAID')
            ->exists();

        if ($alreadyProcessed) {
            return $this->sendError('تم معالجة هذه العملية مسبقًا', 409, [
                'referenceNumber' => [$referenceNumber],
            ]);
        }

        // ── Activate Subscription ────────────────────────────────────────────
        $current      = 0;
        $checkPricing = UserPriceing::where('user_id', $userId)->where('statues', 1)->orderByDesc('id')->first();

        if ($checkPricing) {
            $checkPricing->update(['statues' => 0]);
            if ($checkPricing->current_points >= 0) {
                $current = $checkPricing->current_points;
            }
        }

        UserPriceing::create([
            'user_id'        => $userId,
            'pricing_id'     => $pric->id,
            'statues'        => 1,
            'start_points'   => $pric->points,
            'current_points' => $pric->points + $current,
            'sub_points'     => 0,
        ]);

        FawryPayment::where('referenceNumber', $referenceNumber)
            ->update(['paymentStatus' => 'PAID', 'paid_at' => now()]);

        return $this->sendResponse([
            'points'  => $pric->points + $current,
            'message' => "ربحت معنا {$pric->points} نقطة! ممكن تتعامل مع المالك مباشرة بدون عمولة.",
        ], 'تم تفعيل الاشتراك بنجاح');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // GET /api/fawry/vip-callback   (تمييز إعلان)
    // ─────────────────────────────────────────────────────────────────────────

    public function tmyezzFawryCallback(Request $request): JsonResponse
    {
        // ── Validation ───────────────────────────────────────────────────────
        $validator = Validator::make(
            $request->query(),
            [
                'orderStatus'       => 'required|string|in:PAID,UNPAID,EXPIRED,FAILED,CANCELED',
                'customerProfileId' => ['required', 'string', 'regex:/^\d+55555\d+$/'],
                'referenceNumber'   => 'required|string',
                'paymentAmount'     => 'nullable|numeric|min:0',
            ],
            array_merge($this->arabicMessages, [
                'orderStatus.in'           => 'حالة الطلب غير صحيحة. القيم المقبولة: PAID, UNPAID, EXPIRED, FAILED, CANCELED.',
                'customerProfileId.regex'  => 'تنسيق customerProfileId غير صحيح. يجب أن يكون بالشكل: {vip_id}55555{aqar_id}.',
                'referenceNumber.required' => 'رقم المرجع (referenceNumber) مطلوب.',
            ]),
            [
                'orderStatus'       => 'حالة الطلب',
                'customerProfileId' => 'معرف العميل',
                'referenceNumber'   => 'رقم المرجع',
                'paymentAmount'     => 'مبلغ الدفع',
            ]
        );

        if ($validator->fails()) {
            return $this->sendError('بيانات الـ callback غير صحيحة', 422, $validator->errors()->toArray());
        }

        // ── Check payment status ─────────────────────────────────────────────
        if ($request->query('orderStatus') !== 'PAID') {
            return $this->sendError('الدفع لم يكتمل', 400, [
                'orderStatus' => [$request->query('orderStatus')],
                'message'     => ['لم يتم الدفع بنجاح. حالة الطلب: ' . $request->query('orderStatus')],
            ]);
        }

        // ── Parse customerProfileId ─────────────────────────────────────────
        $pieces = explode('55555', $request->query('customerProfileId'));
        $aqarId = $pieces[1] ?? null;

        if (!$aqarId || !is_numeric($aqarId)) {
            return $this->sendError('معرف الإعلان غير صحيح', 422, [
                'aqar_id' => ['تعذر تحديد الإعلان من بيانات الدفع.'],
            ]);
        }

        $aqar = aqar::find($aqarId);
        if (!$aqar) {
            Log::error("Fawry VIP callback: aqar_id={$aqarId} not found");
            return $this->sendError('الإعلان غير موجود', 404, [
                'aqar_id' => ["الإعلان رقم {$aqarId} غير موجود في النظام."],
            ]);
        }

        // التحقق من عدم تكرار نفس الدفعة
        $referenceNumber  = $request->query('referenceNumber');
        $alreadyProcessed = FawryPayment::where('referenceNumber', $referenceNumber)
            ->where('paymentStatus', 'PAID')
            ->exists();

        if ($alreadyProcessed) {
            return $this->sendError('تم معالجة هذه العملية مسبقًا', 409, [
                'referenceNumber' => [$referenceNumber],
            ]);
        }

        if ($aqar->vip == 1) {
            return $this->sendError('الإعلان مميز بالفعل', 409, [
                'aqar_id' => ["الإعلان رقم {$aqarId} مميز بالفعل."],
            ]);
        }

        $aqar->vip = 1;
        $aqar->save();

        FawryPayment::where('referenceNumber', $referenceNumber)
            ->update(['paymentStatus' => 'PAID', 'paid_at' => now()]);

        return $this->sendResponse([
            'aqar_id' => $aqar->id,
            'vip'     => true,
        ], 'تم تمييز إعلانك بنجاح');
    }
}

