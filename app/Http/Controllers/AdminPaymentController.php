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
use App\Models\PaymentRefund;
use App\Services\PaymentReportService;
use App\Services\PaymentService;
use Illuminate\Http\Request;

class AdminPaymentController extends Controller
{
    private PaymentService $paymentService;
    private PaymentReportService $reportService;

    public function __construct(PaymentService $paymentService, PaymentReportService $reportService)
    {
        $this->paymentService = $paymentService;
        $this->reportService  = $reportService;
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

        return redirect()->back()->with('success', 'تم تحديث حالة الدفعة بنجاح.');
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

        $adminId = \Auth::guard('admin')->id();
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
