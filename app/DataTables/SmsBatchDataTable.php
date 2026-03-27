<?php

namespace App\DataTables;

use App\Enums\SmsBatchStatusEnum;
use App\Enums\SmsSendTypeEnum;
use App\Models\SmsBatch;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

/**
 * DataTable for the SMS Batches report page.
 *
 * Shows all SMS campaigns with summary stats, status badges, and action buttons.
 */
class SmsBatchDataTable extends DataTable
{
    public function dataTable($query)
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                $viewUrl = route('sitemanagement.sms.show', $row->id);
                return '<a href="' . $viewUrl . '" class="btn btn-sm btn-info" title="عرض التفاصيل">'
                     . '<i class="fas fa-eye"></i></a>';
            })
            ->editColumn('created_by_user_id', function ($row) {
                return $row->createdBy ? e($row->createdBy->name) : '—';
            })
            ->editColumn('send_type', function ($row) {
                return SmsSendTypeEnum::label($row->send_type);
            })
            ->editColumn('overall_status', function ($row) {
                $badge = SmsBatchStatusEnum::badgeClass($row->overall_status);
                $label = SmsBatchStatusEnum::label($row->overall_status);
                return '<span class="badge ' . $badge . '">' . e($label) . '</span>';
            })
            ->editColumn('message_template', function ($row) {
                // Truncate long messages for the table view
                return '<span title="' . e($row->message_template) . '">'
                     . e(\Illuminate\Support\Str::limit($row->message_template, 50))
                     . '</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d H:i') : '—';
            })
            ->rawColumns(['action', 'overall_status', 'message_template']);
    }

    public function query(SmsBatch $model)
    {
        return $model->newQuery()->with('createdBy')->latest();
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '60px', 'printable' => false, 'title' => 'إجراء'])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [],
                'language'  => ['url' => '//cdn.datatables.net/plug-ins/1.13.7/i18n/ar.json'],
            ]);
    }

    protected function getColumns()
    {
        return [
            ['data' => 'id',                    'name' => 'id',                    'title' => '#'],
            ['data' => 'message_template',      'name' => 'message_template',      'title' => 'نص الرسالة'],
            ['data' => 'send_type',             'name' => 'send_type',             'title' => 'نوع الإرسال'],
            ['data' => 'total_recipients',      'name' => 'total_recipients',      'title' => 'المستلمين'],
            ['data' => 'total_sent',            'name' => 'total_sent',            'title' => 'تم الإرسال'],
            ['data' => 'total_failed',          'name' => 'total_failed',          'title' => 'فشل'],
            ['data' => 'total_invalid_numbers', 'name' => 'total_invalid_numbers', 'title' => 'غير صالح'],
            ['data' => 'overall_status',        'name' => 'overall_status',        'title' => 'الحالة'],
            ['data' => 'created_by_user_id',    'name' => 'created_by_user_id',    'title' => 'بواسطة'],
            ['data' => 'created_at',            'name' => 'created_at',            'title' => 'التاريخ'],
        ];
    }

    protected function filename(): string
    {
        return 'sms_batches_' . time();
    }
}
