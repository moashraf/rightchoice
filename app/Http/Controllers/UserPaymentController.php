<?php

namespace App\Http\Controllers;

use App\Enums\PaymentStatusEnum;
use App\Enums\RefundStatusEnum;
use App\Http\Requests\CreateRefundRequest;
use App\Models\FawryPayment;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * User-facing payment history controller.
 * Users can only view their own payments.
 */
class UserPaymentController extends Controller
{
    private PaymentService $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * My Payments - list all user's payments.
     */
    public function index(Request $request)
    {
        $userId = Auth::id();

        $query = FawryPayment::where('user_id', $userId)
            ->with(['pricingSale:id,type,price', 'priceVip:id,name,price']);

        // Filters
        if ($status = $request->get('status')) {
            $query->where('paymentStatus', $status);
        }
        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $payments = $query->orderByDesc('created_at')->paginate(15);

        // Summary stats for the user
        $totalPaid    = FawryPayment::where('user_id', $userId)->where('paymentStatus', PaymentStatusEnum::PAID)->sum('paymentAmount');
        $totalRefunded = FawryPayment::where('user_id', $userId)->sum('refunded_amount');
        $paymentCount = FawryPayment::where('user_id', $userId)->count();

        $statuses = PaymentStatusEnum::labels();

        return view('user_payments.index', compact('payments', 'totalPaid', 'totalRefunded', 'paymentCount', 'statuses'));
    }

    /**
     * Show single payment details.
     */
    public function show(int $id)
    {
        $payment = FawryPayment::where('user_id', Auth::id())
            ->with(['pricingSale', 'priceVip', 'refunds'])
            ->findOrFail($id);

        return view('user_payments.show', compact('payment'));
    }

    /**
     * Request a refund for a payment.
     */
    public function requestRefund(CreateRefundRequest $request, int $id)
    {
        $payment = FawryPayment::where('user_id', Auth::id())->findOrFail($id);

        if (!$payment->canRefund()) {
            return redirect()->back()->with('error', 'لا يمكن طلب استرداد لهذه الدفعة.');
        }

        $maxRefundable = $payment->getRefundableAmount();
        if ($request->refund_amount > $maxRefundable) {
            return redirect()->back()->with('error', "الحد الأقصى للاسترداد هو {$maxRefundable} ج.م");
        }

        $this->paymentService->createRefundRequest($payment, $request->refund_amount, $request->refund_reason, Auth::id());

        return redirect()->back()->with('success', 'تم إرسال طلب الاسترداد بنجاح. سيتم مراجعته من قبل الإدارة.');
    }
}
