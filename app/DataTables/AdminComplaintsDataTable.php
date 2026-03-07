<?php

namespace App\DataTables;

use App\Models\Complaints;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminComplaintsDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'admin_complaints.datatables_actions')
            ->addColumn('user_name', function ($row) {
                return $row->userinfo ? $row->userinfo->name : '-';
            })
            ->addColumn('aqar_title', function ($row) {
                return $row->aqarinfo ? $row->aqarinfo->title : '-';
            })
            ->addColumn('status_label', function ($row) {
                if ($row->status == Complaints::COMPLAINT_PENDING)    return '<span class="badge badge-warning">متوقف</span>';
                if ($row->status == Complaints::COMPLAINT_INPROGRESS) return '<span class="badge badge-info">جاري العمل</span>';
                if ($row->status == Complaints::COMPLAINT_SOLVED)     return '<span class="badge badge-success">تم الحل</span>';
                return '-';
            })
            ->rawColumns(['action', 'status_label']);
    }

    public function query(Complaints $model)
    {
        $query = $model->newQuery()->with(['userinfo', 'aqarinfo']);

        if (request()->filled('user_id')) {
            $query->where('user_id', request('user_id'));
        }

        if (request()->filled('status')) {
            $query->where('status', request('status'));
        }

        return $query;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('complaints-table')
            ->columns($this->getColumns())
            ->minifiedAjax('', "
                data.user_id = $('#filter_user_id').val();
                data.status  = $('#filter_status').val();
            ")
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => false,
                'order'     => [[0, 'desc']],
                'buttons'   => [],
            ]);
    }

    protected function getColumns()
    {
        return [
            'id',
            'user_name'    => ['title' => 'المستخدم',  'data' => 'user_name',    'name' => 'user_name',    'searchable' => false, 'orderable' => false],
            'aqar_title'   => ['title' => 'العقار',    'data' => 'aqar_title',   'name' => 'aqar_title',   'searchable' => false, 'orderable' => false],
            'message',
            'status_label' => ['title' => 'الحالة',    'data' => 'status_label', 'name' => 'status_label', 'searchable' => false, 'orderable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'complaints_' . date('YmdHis');
    }
}
