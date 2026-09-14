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
        return $this->renderPayments($request);
    }

    public function paid(Request $request)
    {
        return $this->renderPayments($request, true);
    }

    public function unpaid(Request $request)
    {
        return $this->renderPayments($request, false);
    }

    private function renderPayments(Request $request, ?bool $paidOnly = null)
    {
        $userId = Auth::id();

        $query = FawryPayment::where('user_id', $userId)
            ->with([
                'pricingSale:id,type,price,discount_percentage',
                'priceVip:id,name,price,discount_percentage,duration_days',
                'propertyPromotion:id,fawry_payment_id,aqar_id,status,started_at,expires_at,duration_days',
                'propertyPromotion.aqar:id,title,title_en,slug,slug_en',
            ]);

        if ($paidOnly === true) {
            $query->where('paymentStatus', PaymentStatusEnum::PAID);
        } elseif ($paidOnly === false) {
            $query->where(function ($statusQuery) {
                $statusQuery->where('paymentStatus', '!=', PaymentStatusEnum::PAID)
                    ->orWhereNull('paymentStatus');
            });
        } elseif ($status = $request->get('status')) {
            $query->where('paymentStatus', $status);
        }

        if ($dateFrom = $request->get('date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = $request->get('date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $payments = $query->orderByDesc('created_at')->paginate(15);

        $totalPaid = FawryPayment::where('user_id', $userId)
            ->where('paymentStatus', PaymentStatusEnum::PAID)
            ->sum('paymentAmount');
        $totalRefunded = FawryPayment::where('user_id', $userId)->sum('refunded_amount');
        $paymentCount = FawryPayment::where('user_id', $userId)->count();
        $statuses = PaymentStatusEnum::labels();

        $paymentScope = $paidOnly === true ? 'paid' : ($paidOnly === false ? 'unpaid' : 'all');
        $pageTitle = $paidOnly === true
            ? 'عمليات الدفع المدفوعة'
            : ($paidOnly === false ? 'عمليات الدفع غير المدفوعة' : trans('langsite.my_payments'));

        return view('user_payments.index', compact(
            'payments',
            'totalPaid',
            'totalRefunded',
            'paymentCount',
            'statuses',
            'paymentScope',
            'pageTitle'
        ));
    }

    /**
     * List every payment reference requested by the authenticated user.
     */
    public function references()
    {
        $payments = FawryPayment::query()
            ->where('user_id', Auth::id())
            ->with([
                'pricingSale:id,type',
                'priceVip:id,name',
            ])
            ->orderByDesc('created_at')
            ->paginate(20);

        $paidCount = FawryPayment::where('user_id', Auth::id())
            ->where('paymentStatus', PaymentStatusEnum::PAID)
            ->count();

        $unpaidCount = FawryPayment::where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('paymentStatus', '!=', PaymentStatusEnum::PAID)
                    ->orWhereNull('paymentStatus');
            })
            ->count();

        return view('user_payments.references', compact('payments', 'paidCount', 'unpaidCount'));
    }

    /**
     * Show single payment details.
     */
    public function show(Request $request)
    {
        $id = (int) $request->route('id');

        $payment = FawryPayment::where('user_id', Auth::id())
            ->with(['pricingSale', 'priceVip', 'refunds'])
            ->findOrFail($id);

        return view('user_payments.show', compact('payment'));
    }

    /**
     * Request a refund for a payment.
     */
    public function requestRefund(CreateRefundRequest $request)
    {
        $id = (int) $request->route('id');
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
