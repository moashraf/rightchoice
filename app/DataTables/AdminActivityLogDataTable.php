<?php

namespace App\DataTables;

use App\Models\ActivityLog;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminActivityLogDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'admin_activity_logs.datatables_actions')
            ->editColumn('description', function ($row) {
                $short = mb_substr($row->description, 0, 80);
                $suffix = mb_strlen($row->description) > 80 ? '...' : '';
                return '<span title="' . e($row->description) . '">' . e($short . $suffix) . '</span>';
            })
            ->editColumn('subject_type', function ($row) {
                if (!$row->subject_type) return '-';
                return '<span title="' . e($row->subject_type) . '">' . e(class_basename($row->subject_type)) . '</span>';
            })
            ->editColumn('causer_type', function ($row) {
                if (!$row->causer_type) return '-';
                return '<span title="' . e($row->causer_type) . '">' . e(class_basename($row->causer_type)) . '</span>';
            })
            ->editColumn('causer_id', function ($row) {
                return $row->causer_id ?? '-';
            })
            ->editColumn('event', function ($row) {
                if (!$row->event) return '-';
                $colors = [
                    'created' => 'success',
                    'updated' => 'warning',
                    'deleted' => 'danger',
                ];
                $color = $colors[$row->event] ?? 'secondary';
                return '<span class="badge badge-' . $color . '">' . e($row->event) . '</span>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at ? $row->created_at->diffForHumans() : '-';
            })
            ->escapeColumns([]);
    }

    public function query(ActivityLog $model)
    {
        return $model->newQuery()->orderBy('created_at', 'desc');
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
                'autoWidth' => false,
                'language'  => [
                    'url' => '//cdn.datatables.net/plug-ins/1.13.1/i18n/ar.json',
                ],
            ]);
    }

    protected function getColumns()
    {
        return [
            'id',
            'log_name'     => ['title' => 'اسم السجل'],
            'description'  => ['title' => 'الوصف'],
            'event'        => ['title' => 'الحدث'],
            'subject_type' => ['title' => 'نوع العنصر'],
            'subject_id'   => ['title' => 'رقم العنصر'],
            'causer_type'  => ['title' => 'نوع المسبب'],
            'causer_id'    => ['title' => 'رقم المسبب'],
            'created_at'   => ['title' => 'التاريخ'],
        ];
    }

    protected function filename(): string
    {
        return 'admin_activity_logs_datatable_' . time();
    }
}
