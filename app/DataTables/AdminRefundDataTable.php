<?php

namespace App\DataTables;

use App\Models\PaymentRefund;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminRefundDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', function ($refund) {
                $showUrl = route('sitemanagement.payments.show', $refund->payment_id);
                $btns = '<a href="' . $showUrl . '" class="btn btn-sm btn-info mr-1" title="عرض الدفعة"><i class="fas fa-eye"></i></a>';

                if ($refund->refund_status === 'requested' || $refund->refund_status === 'under_review') {
                    $btns .= '<button class="btn btn-sm btn-success mr-1 btn-approve-refund" data-id="' . $refund->id . '" title="موافقة"><i class="fas fa-check"></i></button>';
                    $btns .= '<button class="btn btn-sm btn-danger btn-reject-refund" data-id="' . $refund->id . '" title="رفض"><i class="fas fa-times"></i></button>';
                }
                if ($refund->refund_status === 'approved') {
                    $btns .= '<button class="btn btn-sm btn-primary btn-mark-refunded" data-id="' . $refund->id . '" title="تنفيذ الاسترداد"><i class="fas fa-undo"></i></button>';
                }

                return $btns;
            })
            ->editColumn('user_id', function ($refund) {
                return $refund->user ? e($refund->user->name) : ('مستخدم #' . $refund->user_id);
            })
            ->editColumn('refund_amount', function ($refund) {
                return number_format($refund->refund_amount, 2) . ' ج.م';
            })
            ->editColumn('refund_status', function ($refund) {
                return '<span class="badge badge-' . $refund->status_badge . '">' . e($refund->status_label) . '</span>';
            })
            ->addColumn('payment_amount', function ($refund) {
                return $refund->payment ? number_format($refund->payment->paymentAmount, 2) . ' ج.م' : '-';
            })
            ->addColumn('payment_ref', function ($refund) {
                return $refund->payment->referenceNumber ?? '-';
            })
            ->editColumn('refunded_at', function ($refund) {
                return $refund->refunded_at ? $refund->refunded_at->format('Y-m-d H:i') : '-';
            })
            ->editColumn('created_at', function ($refund) {
                return $refund->created_at ? $refund->created_at->format('Y-m-d H:i') : '-';
            })
            ->escapeColumns([]);
    }

    public function query(PaymentRefund $model)
    {
        $query = $model->newQuery()->with(['user:id,name,email', 'payment:id,paymentAmount,referenceNumber', 'admin:id,name']);

        if ($status = request('filter_refund_status')) {
            $query->where('refund_status', $status);
        }
        if ($dateFrom = request('filter_date_from')) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }
        if ($dateTo = request('filter_date_to')) {
            $query->whereDate('created_at', '<=', $dateTo);
        }
        if ($userId = request('filter_user_id')) {
            $query->where('user_id', $userId);
        }

        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false, 'title' => 'إجراءات'])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'csv', 'text' => '<i class="fas fa-file-csv"></i> CSV', 'className' => 'btn btn-sm btn-outline-success'],
                    ['extend' => 'excel', 'text' => '<i class="fas fa-file-excel"></i> Excel', 'className' => 'btn btn-sm btn-outline-primary'],
                ],
                'language'  => ['url' => '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'],
            ]);
    }

    protected function getColumns()
    {
        return [
            'id'             => ['title' => '#'],
            'user_id'        => ['title' => 'المستخدم'],
            'payment_ref'    => ['title' => 'رقم مرجع الدفعة', 'orderable' => false, 'searchable' => false],
            'payment_amount' => ['title' => 'مبلغ الدفعة', 'orderable' => false, 'searchable' => false],
            'refund_amount'  => ['title' => 'مبلغ الاسترداد'],
            'refund_status'  => ['title' => 'الحالة'],
            'refund_reason'  => ['title' => 'السبب'],
            'refunded_at'    => ['title' => 'تاريخ الاسترداد'],
            'created_at'     => ['title' => 'تاريخ الطلب'],
        ];
    }

    protected function filename(): string
    {
        return 'refunds_' . time();
    }
}
