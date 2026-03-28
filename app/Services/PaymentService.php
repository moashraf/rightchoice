<?php

namespace App\Services;

use App\Enums\PaymentStatusEnum;
use App\Enums\RefundStatusEnum;
use App\Models\FawryPayment;
use App\Models\PaymentRefund;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Update payment status with logging.
     */
    public function updateStatus(FawryPayment $payment, string $newStatus, ?string $message = null, $payload = null): FawryPayment
    {
        $oldStatus = $payment->paymentStatus;
        $payment->paymentStatus = $newStatus;

        if ($newStatus === PaymentStatusEnum::PAID && !$payment->paid_at) {
            $payment->paid_at = now();
            $payment->net_amount = $payment->paymentAmount - $payment->gateway_fees;
        }

        $payment->save();

        $adminId = Auth::guard('admin')->id();
        $payment->logStatusChange('status_change', $oldStatus, $newStatus, $message, $payload, $adminId);

        return $payment;
    }

    /**
     * Create a refund request (user-initiated or admin-initiated).
     */
    public function createRefundRequest(FawryPayment $payment, float $amount, string $reason, ?int $requestedBy = null): PaymentRefund
    {
        return DB::transaction(function () use ($payment, $amount, $reason, $requestedBy) {
            $refund = PaymentRefund::create([
                'payment_id'    => $payment->id,
                'user_id'       => $payment->user_id,
                'refund_amount' => $amount,
                'refund_status' => RefundStatusEnum::REQUESTED,
                'refund_reason' => $reason,
            ]);

            // Update payment refund_status
            $payment->update(['refund_status' => RefundStatusEnum::REQUESTED]);

            $payment->logStatusChange(
                'refund',
                null,
                RefundStatusEnum::REQUESTED,
                "طلب استرداد مبلغ {$amount} ج.م - السبب: {$reason}",
                null,
                $requestedBy
            );

            return $refund;
        });
    }

    /**
     * Approve a refund request.
     */
    public function approveRefund(PaymentRefund $refund, ?string $adminNote = null): PaymentRefund
    {
        return DB::transaction(function () use ($refund, $adminNote) {
            $adminId = Auth::guard('admin')->id();

            $refund->update([
                'refund_status' => RefundStatusEnum::APPROVED,
                'admin_id'      => $adminId,
                'admin_note'    => $adminNote,
                'approved_at'   => now(),
            ]);

            $refund->payment->update(['refund_status' => RefundStatusEnum::APPROVED]);

            $refund->payment->logStatusChange(
                'refund',
                RefundStatusEnum::REQUESTED,
                RefundStatusEnum::APPROVED,
                "تمت الموافقة على الاسترداد - {$refund->refund_amount} ج.م",
                null,
                $adminId
            );

            return $refund;
        });
    }

    /**
     * Reject a refund request.
     */
    public function rejectRefund(PaymentRefund $refund, ?string $adminNote = null): PaymentRefund
    {
        return DB::transaction(function () use ($refund, $adminNote) {
            $adminId = Auth::guard('admin')->id();

            $refund->update([
                'refund_status' => RefundStatusEnum::REJECTED,
                'admin_id'      => $adminId,
                'admin_note'    => $adminNote,
                'rejected_at'   => now(),
            ]);

            $refund->payment->update(['refund_status' => RefundStatusEnum::REJECTED]);

            $refund->payment->logStatusChange(
                'refund',
                $refund->getOriginal('refund_status'),
                RefundStatusEnum::REJECTED,
                "تم رفض الاسترداد" . ($adminNote ? ": {$adminNote}" : ''),
                null,
                $adminId
            );

            return $refund;
        });
    }

    /**
     * Mark refund as completed/refunded.
     */
    public function markRefunded(PaymentRefund $refund, ?string $refundReferenceNumber = null, ?string $adminNote = null): PaymentRefund
    {
        return DB::transaction(function () use ($refund, $refundReferenceNumber, $adminNote) {
            $adminId = Auth::guard('admin')->id();

            $refund->update([
                'refund_status'          => RefundStatusEnum::REFUNDED,
                'admin_id'               => $adminId,
                'admin_note'             => $adminNote,
                'refund_reference_number' => $refundReferenceNumber,
                'refunded_at'            => now(),
            ]);

            // Recalculate parent payment refund totals
            $refund->payment->recalculateRefunds();

            $refund->payment->logStatusChange(
                'refund',
                RefundStatusEnum::APPROVED,
                RefundStatusEnum::REFUNDED,
                "تم تنفيذ الاسترداد - {$refund->refund_amount} ج.م",
                null,
                $adminId
            );

            return $refund;
        });
    }

    /**
     * Add admin note to a payment.
     */
    public function addNote(FawryPayment $payment, string $noteText): void
    {
        $payment->notes()->create([
            'admin_id' => Auth::guard('admin')->id(),
            'note'     => $noteText,
        ]);
    }
}
