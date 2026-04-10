<?php

namespace App\Http\Controllers\API;

use App\Enums\PaymentStatusEnum;
use App\Models\FawryPayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Validator;

/**
 * User Payment History API Controller.
 */
class UserPaymentAPIController extends AppBaseController
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * GET /api/my-payments
     */
    public function index(Request $request): JsonResponse
    {
        $userId = $request->user()->id;

        $query = FawryPayment::where('user_id', $userId)
            ->with(['pricingSale:id,type,price', 'priceVip:id,name,price']);

        if ($request->filled('status')) {
            $query->where('paymentStatus', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->orderByDesc('created_at')->paginate($request->get('per_page', 15));

        $totalPaid     = FawryPayment::where('user_id', $userId)->where('paymentStatus', PaymentStatusEnum::PAID)->sum('paymentAmount');
        $totalRefunded = FawryPayment::where('user_id', $userId)->sum('refunded_amount');
        $paymentCount  = FawryPayment::where('user_id', $userId)->count();

        return $this->sendResponse([
            'payments'       => $payments->toArray(),
            'total_paid'     => $totalPaid,
            'total_refunded' => $totalRefunded,
            'payment_count'  => $paymentCount,
        ], 'Payments retrieved successfully');
    }

    /**
     * GET /api/my-payments/{id}
     */
    public function show(Request $request, int $id): JsonResponse
    {
        $payment = FawryPayment::where('user_id', $request->user()->id)
            ->with(['pricingSale', 'priceVip', 'refunds'])
            ->find($id);

        if (!$payment) {
            return $this->sendError('Payment not found', 404);
        }

        return $this->sendResponse($payment->toArray(), 'Payment retrieved successfully');
    }

    /**
     * POST /api/my-payments/{id}/refund
     */
    public function requestRefund(Request $request, int $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'refund_amount' => 'required|numeric|min:1',
            'refund_reason' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation Error', 'errors' => $validator->errors()], 422);
        }

        $payment = FawryPayment::where('user_id', $request->user()->id)->find($id);

        if (!$payment) {
            return $this->sendError('Payment not found', 404);
        }

        if (!$payment->canRefund()) {
            return $this->sendError('Cannot request refund for this payment', 400);
        }

        $maxRefundable = $payment->getRefundableAmount();
        if ($request->refund_amount > $maxRefundable) {
            return $this->sendError("Maximum refundable amount is {$maxRefundable}", 400);
        }

        $this->paymentService->createRefundRequest($payment, $request->refund_amount, $request->refund_reason, $request->user()->id);

        return $this->sendSuccess('Refund request submitted successfully');
    }
}

