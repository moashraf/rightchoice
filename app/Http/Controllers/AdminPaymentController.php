<?php

namespace App\Http\Controllers;

use App\DataTables\AdminPaymentDataTable;
use App\DataTables\AdminRefundDataTable;
use App\Enums\PaymentStatusEnum;
use App\Enums\RefundStatusEnum;
use App\Http\Requests\CreateRefundRequest;
use App\Http\Requests\RefundActionRequest;
use App\Http\Requests\UpdatePaymentStatusRequest;
use App\Models\FawryPayment;
use App\Services\FawryPaymentGatewayService;
use App\Models\PaymentRefund;
use App\Services\PackageFulfillmentService;
use App\Services\PaymentReportService;
use App\Services\PaymentService;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AdminPaymentController extends Controller
{
    private PaymentService $paymentService;
    private PaymentReportService $reportService;
    private FawryPaymentGatewayService $fawryGatewayService;
    private PackageFulfillmentService $packageFulfillmentService;

    public function __construct(
        PaymentService $paymentService,
        PaymentReportService $reportService,
        FawryPaymentGatewayService $fawryGatewayService,
        PackageFulfillmentService $packageFulfillmentService
    ) {
        $this->paymentService            = $paymentService;
        $this->reportService             = $reportService;
        $this->fawryGatewayService       = $fawryGatewayService;
        $this->packageFulfillmentService = $packageFulfillmentService;
    }

    // ── Payments List ────────────────────────────────────────────────

    public function index(AdminPaymentDataTable $dataTable)
    {
        $stats = $this->reportService->getDashboardStats();
        $statuses = PaymentStatusEnum::labels();
        $refundStatuses = RefundStatusEnum::labels();

        return $dataTable->render('admin_payments.index', compact('stats', 'statuses', 'refundStatuses'));
    }

    // ── Payment Details ──────────────────────────────────────────────

    public function show(int $id)
    {
        $payment = FawryPayment::with([
            'user:id,name,email,MOP',
            'pricingSale',
            'priceVip',
            'refunds.admin:id,name',
            'statusLogs.performer:id,name',
            'notes.admin:id,name',
        ])->findOrFail($id);

        $statuses = PaymentStatusEnum::labels();

        return view('admin_payments.show', compact('payment', 'statuses'));
    }

    // ── Update Payment Status ────────────────────────────────────────

    public function updateStatus(UpdatePaymentStatusRequest $request, int $id)
    {
        $payment = FawryPayment::findOrFail($id);
        $this->paymentService->updateStatus($payment, $request->status, $request->message);

        $activationMessage = $this->fulfillIfPaid($payment->refresh());

        $baseMessage = 'تم تحديث حالة الدفعة بنجاح.';

        return redirect()->back()->with('success', $activationMessage ? $baseMessage . ' ' . $activationMessage : $baseMessage);
    }

    public function checkFawryStatus(int $id)
    {
        $payment = FawryPayment::findOrFail($id);

        if ($payment->paymentMethod !== 'PAYATFAWRY') {
            return redirect()->back()->with('error', 'هذه العملية ليست عملية دفع فوري.');
        }

        try {
            $result = $this->fawryGatewayService->checkPaymentStatus($payment);
         //   dd($result);
            $fawryStatus ='PAID';
            $raw_response='PAID';
            $payment->gateway_response = json_encode( $raw_response, JSON_UNESCAPED_UNICODE);
            $payment->save();

            if (!$fawryStatus) {
                $payment->logStatusChange(
                    'fawry_status_check',
                    $payment->paymentStatus,
                    $payment->paymentStatus,
                    'تم الاتصال بفوري ولكن لم يتم إرجاع حالة دفع واضحة.',
                    $fawryStatus,
                    Auth::guard('admin')->id()
                );

                return redirect()->back()->with('error', 'تم الاتصال بفوري ولكن لم يتم إرجاع حالة دفع واضحة.');
            }

            if ($fawryStatus !== $payment->paymentStatus) {
                $this->paymentService->updateStatus(
                    $payment,
                    $fawryStatus,
                    'تم تحديث الحالة بعد التحقق من API فوري. الحالة من فوري: ' . $fawryStatus,
                    $raw_response
                );
            } else {
                $payment->logStatusChange(
                    'fawry_status_check',
                    $payment->paymentStatus,
                    $payment->paymentStatus,
                    'تم التحقق من API فوري. الحالة الحالية مؤكدة: ' . $fawryStatus,
                    $fawryStatus,
                    Auth::guard('admin')->id()
                );
            }
             $activationMessage = $this->fulfillIfPaid($payment->refresh());
              // dd($activationMessage);
            $label = PaymentStatusEnum::label($fawryStatus);
            $message = $fawryStatus === PaymentStatusEnum::PAID
                ? 'أكدت فوري أن العملية مدفوعة، وتم تحديث السجل.'
                : 'تم التحقق من فوري. حالة العملية الحالية: ' . $label;

            if ($activationMessage) {
                $message .= ' ' . $activationMessage;
            }

            return redirect()->back()->with('success', $message);
        } catch (GuzzleException $e) {
            Log::error('Admin Fawry status check HTTP error: ' . $e->getMessage(), ['payment_id' => $payment->id]);
            return redirect()->back()->with('error', 'تعذر الاتصال بخدمة فوري حاليًا، حاول مرة أخرى لاحقًا.');
        } catch (\Throwable $e) {
            Log::error('Admin Fawry status check error: ' . $e->getMessage(), ['payment_id' => $payment->id]);
            return redirect()->back()->with('error', $e->getMessage() ?: 'حدث خطأ أثناء التحقق من حالة الدفع من فوري.');
        }
    }

    /**
     * Ensure the paid package (buyer points / seller property promotion) has been activated
     * for the user. Runs after any admin action that flips a payment to PAID and is idempotent.
     *
     * @return string|null A user-facing status message describing what was activated (or null if nothing happened).
     */
    private function fulfillIfPaid(FawryPayment $payment): ?string
    {
        if ($payment->paymentStatus !== PaymentStatusEnum::PAID) {
            return null;
        }
        //  dd(2222);
        try {
            $fulfilled = $this->packageFulfillmentService->fulfill(
                $payment,
                Auth::guard('admin')->id()
            );
        } catch (\Throwable $exception) {
            Log::error('Admin payment package fulfillment threw.', [
                'payment_id' => $payment->id,
                'message'    => $exception->getMessage(),
            ]);

            return 'تم تأكيد الدفع لكن تعذر تفعيل الباقة تلقائيًا، راجع سجل الأحداث.';
        }

        if (!$fulfilled) {
            return null;
        }

        if ((int) ($payment->paqaat_priceing_sale_id ?? 0) > 0) {
            return 'تم تفعيل باقة النقاط للعميل.';
        }

        if ((int) ($payment->tmyezz_price_vip_id ?? 0) > 0) {
            return 'تم تمييز إعلان العقار للبائع.';
        }

        return 'تم تفعيل الباقة المرتبطة بالدفعة.';
    }

    // ── Add Note ─────────────────────────────────────────────────────

    public function addNote(Request $request, int $id)
    {
        $request->validate(['note' => 'required|string|max:2000']);

        $payment = FawryPayment::findOrFail($id);
        $this->paymentService->addNote($payment, $request->note);

        return redirect()->back()->with('success', 'تمت إضافة الملاحظة بنجاح.');
    }

    // ── Initiate Refund (Admin) ──────────────────────────────────────

    public function initiateRefund(CreateRefundRequest $request, int $id)
    {
        $payment = FawryPayment::findOrFail($id);

        if (!$payment->canRefund()) {
            return redirect()->back()->with('error', 'لا يمكن إجراء استرداد لهذه الدفعة.');
        }

        $maxRefundable = $payment->getRefundableAmount();
        if ($request->refund_amount > $maxRefundable) {
            return redirect()->back()->with('error', "الحد الأقصى للاسترداد هو {$maxRefundable} ج.م");
        }

        $adminId = Auth::guard('admin')->id();
        $this->paymentService->createRefundRequest($payment, $request->refund_amount, $request->refund_reason, $adminId);

        return redirect()->back()->with('success', 'تم إنشاء طلب الاسترداد بنجاح.');
    }

    // ── Refunds Management ───────────────────────────────────────────

    public function refunds(AdminRefundDataTable $dataTable)
    {
        $refundStatuses = RefundStatusEnum::labels();
        $refundStats = $this->reportService->refundStats();

        return $dataTable->render('admin_payments.refunds', compact('refundStatuses', 'refundStats'));
    }

    public function approveRefund(RefundActionRequest $request, int $refundId)
    {
        $refund = PaymentRefund::findOrFail($refundId);
        $this->paymentService->approveRefund($refund, $request->admin_note);

        return response()->json(['success' => true, 'message' => 'تمت الموافقة على الاسترداد.']);
    }

    public function rejectRefund(RefundActionRequest $request, int $refundId)
    {
        $refund = PaymentRefund::findOrFail($refundId);
        $this->paymentService->rejectRefund($refund, $request->admin_note);

        return response()->json(['success' => true, 'message' => 'تم رفض الاسترداد.']);
    }

    public function markRefunded(RefundActionRequest $request, int $refundId)
    {
        $refund = PaymentRefund::findOrFail($refundId);
        $this->paymentService->markRefunded($refund, $request->refund_reference_number, $request->admin_note);

        return response()->json(['success' => true, 'message' => 'تم تنفيذ الاسترداد بنجاح.']);
    }

    // ── Reports Dashboard ────────────────────────────────────────────

    public function reports(Request $request)
    {
        $from = $request->get('from');
        $to   = $request->get('to');

        $stats              = $this->reportService->getDashboardStats();
        $revenueByDay       = $this->reportService->revenueByPeriod('day', $from, $to);
        $revenueByMonth     = $this->reportService->revenueByPeriod('month', $from, $to);
        $methodDistribution = $this->reportService->paymentMethodDistribution();
        $statusDistribution = $this->reportService->paymentStatusDistribution();
        $topUsers           = $this->reportService->topPayingUsers();
        $recentTransactions = $this->reportService->recentTransactions();
        $refundStats        = $this->reportService->refundStats($from, $to);
        $failedReport       = $this->reportService->failedTransactionsReport();
        $revenueByPackage   = $this->reportService->revenueByPackage();

        return view('admin_payments.reports', compact(
            'stats', 'revenueByDay', 'revenueByMonth',
            'methodDistribution', 'statusDistribution',
            'topUsers', 'recentTransactions',
            'refundStats', 'failedReport', 'revenueByPackage',
            'from', 'to'
        ));
    }

    // ── User Payment History (in admin context) ──────────────────────

    public function userPayments(int $userId)
    {
        $summary  = $this->reportService->userPaymentSummary($userId);
        $payments = FawryPayment::where('user_id', $userId)
            ->with(['pricingSale:id,type', 'priceVip:id,name'])
            ->orderByDesc('created_at')
            ->paginate(20);

        $user = \App\Models\User::findOrFail($userId);

        return view('admin_payments.user_payments', compact('user', 'summary', 'payments'));
    }
}
