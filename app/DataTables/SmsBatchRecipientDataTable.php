<?php

namespace App\DataTables;

use App\Enums\SmsSendStatusEnum;
use App\Models\SmsBatchRecipient;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Services\DataTable;

/**
 * DataTable for SMS batch recipient details page.
 *
 * Shows per-recipient send status, personalized message, mobile number,
 * failure reasons, and timestamps. Filtered by batch_id.
 */
class SmsBatchRecipientDataTable extends DataTable
{
    private ?int $batchId = null;

    /**
     * Set the batch ID to filter recipients.
     */
    public function setBatchId(int $batchId): self
    {
        $this->batchId = $batchId;
        return $this;
    }

    public function dataTable($query)
    {
        return (new EloquentDataTable($query))
            ->editColumn('send_status', function ($row) {
                $badge = SmsSendStatusEnum::badgeClass($row->send_status);
                $label = SmsSendStatusEnum::label($row->send_status);
                return '<span class="badge ' . $badge . '">' . e($label) . '</span>';
            })
            ->editColumn('personalized_message', function ($row) {
                return '<span title="' . e($row->personalized_message) . '">'
                     . e(\Illuminate\Support\Str::limit($row->personalized_message, 50))
                     . '</span>';
            })
            ->editColumn('failure_reason', function ($row) {
                if (empty($row->failure_reason)) return '—';
                return '<span class="text-danger" title="' . e($row->failure_reason) . '">'
                     . e(\Illuminate\Support\Str::limit($row->failure_reason, 40))
                     . '</span>';
            })
            ->editColumn('sent_at', function ($row) {
                return $row->sent_at ? $row->sent_at->format('Y-m-d H:i:s') : '—';
            })
            ->rawColumns(['send_status', 'personalized_message', 'failure_reason']);
    }

    public function query(SmsBatchRecipient $model)
    {
        $query = $model->newQuery();

        if ($this->batchId) {
            $query->where('batch_id', $this->batchId);
        }

        return $query->latest();
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            ['data' => 'recipient_name',        'name' => 'recipient_name',        'title' => 'الاسم'],
            ['data' => 'recipient_mobile',      'name' => 'recipient_mobile',      'title' => 'الرقم الأصلي'],
            ['data' => 'normalized_mobile',     'name' => 'normalized_mobile',     'title' => 'الرقم المعدل'],
            ['data' => 'personalized_message',  'name' => 'personalized_message',  'title' => 'الرسالة'],
            ['data' => 'send_status',           'name' => 'send_status',           'title' => 'الحالة'],
            ['data' => 'failure_reason',        'name' => 'failure_reason',        'title' => 'سبب الفشل'],
            ['data' => 'sent_at',               'name' => 'sent_at',              'title' => 'وقت الإرسال'],
        ];
    }

    protected function filename(): string
    {
        return 'sms_batch_recipients_' . time();
    }
}
