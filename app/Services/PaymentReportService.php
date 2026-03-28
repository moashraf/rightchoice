<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Enums\RefundStatusEnum;
use App\Models\FawryPayment;
use App\Models\PaymentRefund;
use Illuminate\Support\Facades\DB;

/**
 * Service for generating payment reports and statistics.
 */
class PaymentReportService
{
    /**
     * Dashboard summary statistics.
     */
    public function getDashboardStats(): array
    {
        $payments = FawryPayment::query();

        $totalCount     = (clone $payments)->count();
        $successCount   = (clone $payments)->where('paymentStatus', PaymentStatusEnum::PAID)->count();
        $failedCount    = (clone $payments)->where('paymentStatus', PaymentStatusEnum::FAILED)->count();
        $pendingCount   = (clone $payments)->whereIn('paymentStatus', [PaymentStatusEnum::PENDING, PaymentStatusEnum::UNPAID, PaymentStatusEnum::INITIATED])->count();

        $totalRevenue   = (clone $payments)->where('paymentStatus', PaymentStatusEnum::PAID)->sum('paymentAmount');
        $totalRefunded  = (clone $payments)->where('paymentStatus', PaymentStatusEnum::PAID)->sum('refunded_amount');
        $totalFees      = (clone $payments)->where('paymentStatus', PaymentStatusEnum::PAID)->sum('gateway_fees');
        $netRevenue     = $totalRevenue - $totalRefunded - $totalFees;

        return compact(
            'totalCount', 'successCount', 'failedCount', 'pendingCount',
            'totalRevenue', 'totalRefunded', 'totalFees', 'netRevenue'
        );
    }

    /**
     * Revenue grouped by period (day/month).
     */
    public function revenueByPeriod(string $period = 'day', ?string $from = null, ?string $to = null): array
    {
        $format = $period === 'month' ? '%Y-%m' : '%Y-%m-%d';

        $query = FawryPayment::where('paymentStatus', PaymentStatusEnum::PAID)
            ->select(
                DB::raw("DATE_FORMAT(paid_at, '{$format}') as period"),
                DB::raw('SUM(paymentAmount) as revenue'),
                DB::raw('SUM(refunded_amount) as refunded'),
                DB::raw('SUM(gateway_fees) as fees'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('period')
            ->orderBy('period');

        if ($from) $query->where('paid_at', '>=', $from);
        if ($to)   $query->where('paid_at', '<=', $to . ' 23:59:59');

        return $query->get()->toArray();
    }

    /**
     * Payment method distribution.
     */
    public function paymentMethodDistribution(): array
    {
        return FawryPayment::where('paymentStatus', PaymentStatusEnum::PAID)
            ->select('paymentMethod', DB::raw('COUNT(*) as count'), DB::raw('SUM(paymentAmount) as total'))
            ->groupBy('paymentMethod')
            ->get()
            ->toArray();
    }

    /**
     * Payment status distribution.
     */
    public function paymentStatusDistribution(): array
    {
        return FawryPayment::select('paymentStatus', DB::raw('COUNT(*) as count'))
            ->groupBy('paymentStatus')
            ->get()
            ->toArray();
    }

    /**
     * Top paying users.
     */
    public function topPayingUsers(int $limit = 10): array
    {
        return FawryPayment::where('paymentStatus', PaymentStatusEnum::PAID)
            ->select(
                'user_id',
                DB::raw('SUM(paymentAmount) as total_paid'),
                DB::raw('COUNT(*) as payment_count'),
                DB::raw('MAX(paid_at) as last_payment')
            )
            ->groupBy('user_id')
            ->orderByDesc('total_paid')
            ->limit($limit)
            ->with('user:id,name,email')
            ->get()
            ->toArray();
    }

    /**
     * Refund statistics.
     */
    public function refundStats(?string $from = null, ?string $to = null): array
    {
        $query = PaymentRefund::query();

        if ($from) $query->where('created_at', '>=', $from);
        if ($to)   $query->where('created_at', '<=', $to . ' 23:59:59');

        $total     = (clone $query)->count();
        $approved  = (clone $query)->where('refund_status', RefundStatusEnum::APPROVED)->count();
        $rejected  = (clone $query)->where('refund_status', RefundStatusEnum::REJECTED)->count();
        $refunded  = (clone $query)->where('refund_status', RefundStatusEnum::REFUNDED)->count();
        $pending   = (clone $query)->whereIn('refund_status', [RefundStatusEnum::REQUESTED, RefundStatusEnum::UNDER_REVIEW])->count();
        $totalAmount = (clone $query)->where('refund_status', RefundStatusEnum::REFUNDED)->sum('refund_amount');

        // Top refund reasons
        $topReasons = (clone $query)->whereNotNull('refund_reason')
            ->select('refund_reason', DB::raw('COUNT(*) as count'))
            ->groupBy('refund_reason')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->toArray();

        return compact('total', 'approved', 'rejected', 'refunded', 'pending', 'totalAmount', 'topReasons');
    }

    /**
     * Failed transactions report.
     */
    public function failedTransactionsReport(): array
    {
        $failedCount = FawryPayment::where('paymentStatus', PaymentStatusEnum::FAILED)->count();
        $totalCount  = FawryPayment::count();
        $failureRate = $totalCount > 0 ? round(($failedCount / $totalCount) * 100, 2) : 0;

        $commonReasons = FawryPayment::where('paymentStatus', PaymentStatusEnum::FAILED)
            ->whereNotNull('failure_reason')
            ->select('failure_reason', DB::raw('COUNT(*) as count'))
            ->groupBy('failure_reason')
            ->orderByDesc('count')
            ->limit(10)
            ->get()
            ->toArray();

        return compact('failedCount', 'totalCount', 'failureRate', 'commonReasons');
    }

    /**
     * User payment summary for admin user profile.
     */
    public function userPaymentSummary(int $userId): array
    {
        $payments = FawryPayment::where('user_id', $userId);

        return [
            'total_payments'   => (clone $payments)->count(),
            'total_paid'       => (clone $payments)->where('paymentStatus', PaymentStatusEnum::PAID)->sum('paymentAmount'),
            'total_refunded'   => (clone $payments)->sum('refunded_amount'),
            'avg_payment'      => (clone $payments)->where('paymentStatus', PaymentStatusEnum::PAID)->avg('paymentAmount') ?? 0,
            'last_payment'     => (clone $payments)->where('paymentStatus', PaymentStatusEnum::PAID)->max('paid_at'),
            'pending_payments' => (clone $payments)->whereIn('paymentStatus', [PaymentStatusEnum::PENDING, PaymentStatusEnum::UNPAID])->count(),
            'failed_payments'  => (clone $payments)->where('paymentStatus', PaymentStatusEnum::FAILED)->count(),
        ];
    }

    /**
     * Recent transactions.
     */
    public function recentTransactions(int $limit = 10)
    {
        return FawryPayment::with('user:id,name,email')
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Revenue by package/pricing plan.
     */
    public function revenueByPackage(): array
    {
        $byPricing = FawryPayment::where('paymentStatus', PaymentStatusEnum::PAID)
            ->whereNotNull('paqaat_priceing_sale_id')
            ->where('paqaat_priceing_sale_id', '>', 0)
            ->select(
                'paqaat_priceing_sale_id',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(paymentAmount) as total')
            )
            ->groupBy('paqaat_priceing_sale_id')
            ->with('pricingSale:id,type,price')
            ->get()
            ->toArray();

        $byVip = FawryPayment::where('paymentStatus', PaymentStatusEnum::PAID)
            ->whereNotNull('tmyezz_price_vip_id')
            ->where('tmyezz_price_vip_id', '>', 0)
            ->select(
                'tmyezz_price_vip_id',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(paymentAmount) as total')
            )
            ->groupBy('tmyezz_price_vip_id')
            ->with('priceVip:id,name,price')
            ->get()
            ->toArray();

        return ['pricing_sales' => $byPricing, 'vip_packages' => $byVip];
    }
}
