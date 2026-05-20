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
            ->addIndexColumn()
            ->addColumn('action', 'admin_complaints.datatables_actions')
            ->addColumn('user_name', function ($row) {
                if (!$row->userinfo) return '-';
                $url = route('sitemanagement.users.index', ['filter_user_id' => $row->userinfo->id]);
                return '<a href="' . $url . '" target="_blank">' . e($row->userinfo->name) . '</a>';
            })
            ->addColumn('user_phone', function ($row) {
                return $row->userinfo ? '<span class="badge badge-primary">' . e($row->userinfo->MOP) . '</span>' : '-';
            })
            ->addColumn('aqar_title', function ($row) {
                if (!$row->aqarinfo) return '-';
                $url = route('sitemanagement.aqars.index', ['key_word' => $row->aqarinfo->ref_code ?: $row->aqarinfo->title]);
                return '<a href="' . $url . '" target="_blank">' . e(\Illuminate\Support\Str::limit($row->aqarinfo->title, 30)) . '</a>';
            })
            ->addColumn('status_label', function ($row) {
                if ($row->status == Complaints::COMPLAINT_PENDING)    return '<span class="badge badge-warning">متوقف</span>';
                if ($row->status == Complaints::COMPLAINT_INPROGRESS) return '<span class="badge badge-info">جاري العمل</span>';
                if ($row->status == Complaints::COMPLAINT_SOLVED)     return '<span class="badge badge-success">تم الحل</span>';
                return '-';
            })
            ->addColumn('created_date', function ($row) {
                return $row->created_at ? $row->created_at->format('Y-m-d H:i') : '-';
            })
            ->rawColumns(['action', 'status_label', 'user_name', 'user_phone', 'aqar_title']);
    }

    public function query(Complaints $model)
    {
        $query = $model->newQuery()->with(['userinfo', 'aqarinfo'])->orderBy('id', 'DESC');

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
                'order'     => [[1, 'desc']],
                'buttons'   => [],
            ]);
    }

    protected function getColumns()
    {
        return [
            'DT_RowIndex' => ['title' => '#', 'data' => 'DT_RowIndex', 'name' => 'DT_RowIndex', 'searchable' => false, 'orderable' => false],
            'id',
            'user_name'    => ['title' => 'المستخدم',  'data' => 'user_name',    'name' => 'user_name',    'searchable' => false, 'orderable' => false],
            'user_phone'    => ['title' => 'رقم الهاتف',  'data' => 'user_phone',    'name' => 'user_phone',    'searchable' => false, 'orderable' => false],
            'aqar_title'   => ['title' => 'العقار',    'data' => 'aqar_title',   'name' => 'aqar_title',   'searchable' => false, 'orderable' => false],
            'message',
            'status_label' => ['title' => 'الحالة',    'data' => 'status_label', 'name' => 'status_label', 'searchable' => false, 'orderable' => false],
            'created_date' => ['title' => 'تاريخ الإنشاء', 'data' => 'created_date', 'name' => 'created_date', 'searchable' => false, 'orderable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'complaints_' . date('YmdHis');
    }
}
