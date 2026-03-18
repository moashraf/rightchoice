<?php

namespace App\DataTables;

use App\Models\ErrorLog;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminErrorLogDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'admin_error_logs.datatables_actions')
            ->editColumn('message', function ($row) {
                return '<span title="' . e($row->message) . '">' . e(mb_substr($row->message, 0, 80)) . (mb_strlen($row->message) > 80 ? '...' : '') . '</span>';
            })
            ->editColumn('file', function ($row) {
                return '<span title="' . e($row->file) . '">' . e(basename($row->file)) . '</span>';
            })
            ->editColumn('url', function ($row) {
                if (!$row->url) return '-';
                $short = mb_strlen($row->url) > 60 ? mb_substr($row->url, 0, 60) . '...' : $row->url;
                return '<a href="' . e($row->url) . '" target="_blank" title="' . e($row->url) . '">' . e($short) . '</a>';
            })
            ->editColumn('last_occurred_at', function ($row) {
                return $row->last_occurred_at ? $row->last_occurred_at->diffForHumans() : '-';
            })
            ->editColumn('count', function ($row) {
                return '<span class="badge badge-danger">' . $row->count . '</span>';
            })
            ->escapeColumns([]);
    }

    public function query(ErrorLog $model)
    {
        return $model->newQuery()->orderBy('last_occurred_at', 'desc');
    }

    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '80px', 'printable' => false, 'title' => 'إجراءات'])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [],
                'language'  => [
                    'url' => '//cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json',
                ],
            ]);
    }

    protected function getColumns()
    {
        return [
            'id',
            'type'  => ['title' => 'نوع الخطأ'],
            'message' => ['title' => 'الرسالة'],
            'file'  => ['title' => 'الملف'],
            'line'  => ['title' => 'السطر'],
            'url'   => ['title' => 'الرابط'],
            'count' => ['title' => 'التكرار'],
            'last_occurred_at' => ['title' => 'آخر حدوث'],
        ];
    }

    protected function filename(): string
    {
        return 'admin_error_logs_datatable_' . time();
    }
}
