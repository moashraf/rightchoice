<?php

namespace App\DataTables;

use App\Models\FawryPayment;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminPaymentDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', function ($payment) {
                $viewUrl = route('sitemanagement.payments.show', $payment->id);
                return '<a href="' . $viewUrl . '" class="btn btn-sm btn-info" title="عرض التفاصيل"><i class="fas fa-eye"></i></a>';
            })
            ->editColumn('user_id', function ($payment) {
                return $payment->user ? e($payment->user->name) : ('مستخدم #' . $payment->user_id);
            })
            ->editColumn('paymentAmount', function ($payment) {
                return number_format($payment->paymentAmount, 2) . ' ج.م';
            })
            ->editColumn('paymentStatus', function ($payment) {
                $badge = $payment->status_badge;
                $label = $payment->status_label;
                return '<span class="badge badge-' . $badge . '">' . e($label) . '</span>';
            })
            ->editColumn('refund_status', function ($payment) {
                if (!$payment->refund_status) return '-';
                $badge = $payment->refund_status_badge;
                $label = $payment->refund_status_label;
                return '<span class="badge badge-' . $badge . '">' . e($label) . '</span>';
            })
            ->editColumn('refunded_amount', function ($payment) {
                return $payment->refunded_amount > 0 ? number_format($payment->refunded_amount, 2) . ' ج.م' : '-';
            })
            ->editColumn('net_amount', function ($payment) {
                return number_format($payment->net_amount, 2) . ' ج.م';
            })
            ->addColumn('package', function ($payment) {
                return e($payment->package_name);
            })
            ->editColumn('paid_at', function ($payment) {
                return $payment->paid_at ? $payment->paid_at->format('Y-m-d H:i') : '-';
            })
            ->editColumn('created_at', function ($payment) {
                return $payment->created_at ? $payment->created_at->format('Y-m-d H:i') : '-';
            })
            ->escapeColumns([])
            ->filterColumn('user_id', function ($query, $keyword) {
                $query->whereHas('user', function ($q) use ($keyword) {
                    $q->where('name', 'like', "%{$keyword}%")
                      ->orWhere('email', 'like', "%{$keyword}%");
                });
            });
    }

    public function query(FawryPayment $model)
    {
        $query = $model->newQuery()->with(['user:id,name,email', 'pricingSale:id,type', 'priceVip:id,name']);

        // Apply filters from request
        if ($status = request('filter_status')) {
            $query->where('paymentStatus', $status);
        }
        if ($method = request('filter_method')) {
            $query->where('paymentMethod', $method);
        }
        if ($refundStatus = request('filter_refund_status')) {
            $query->where('refund_status', $refundStatus);
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
        if ($refNum = request('filter_reference')) {
            $query->where('referenceNumber', 'like', "%{$refNum}%");
        }

        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '60px', 'printable' => false, 'title' => 'إجراءات'])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'csv', 'text' => '<i class="fas fa-file-csv"></i> CSV', 'className' => 'btn btn-sm btn-outline-success'],
                    ['extend' => 'excel', 'text' => '<i class="fas fa-file-excel"></i> Excel', 'className' => 'btn btn-sm btn-outline-primary'],
                    ['extend' => 'print', 'text' => '<i class="fas fa-print"></i> طباعة', 'className' => 'btn btn-sm btn-outline-secondary'],
                ],
                'language'  => ['url' => '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'],
            ]);
    }

    protected function getColumns()
    {
        return [
            'id'               => ['title' => '#'],
            'user_id'          => ['title' => 'المستخدم'],
            'paymentAmount'    => ['title' => 'المبلغ'],
            'paymentStatus'    => ['title' => 'حالة الدفع'],
            'paymentMethod'    => ['title' => 'طريقة الدفع'],
            'referenceNumber'  => ['title' => 'رقم المرجع'],
            'package'          => ['title' => 'الباقة', 'orderable' => false, 'searchable' => false],
            'paid_at'          => ['title' => 'تاريخ الدفع'],
            'refund_status'    => ['title' => 'حالة الاسترداد'],
            'refunded_amount'  => ['title' => 'المسترد'],
            'net_amount'       => ['title' => 'صافي الربح'],
            'created_at'       => ['title' => 'تاريخ الإنشاء'],
        ];
    }

    protected function filename(): string
    {
        return 'payments_' . time();
    }
}
