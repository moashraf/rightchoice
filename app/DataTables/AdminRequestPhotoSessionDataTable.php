<?php

namespace App\DataTables;

use App\Models\RequestPhotoSession;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminRequestPhotoSessionDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_request_photo_sessions.datatables_actions')
            ->editColumn('created_at', function ($row) {
                return $row->created_at->toDayDateTimeString();
            })
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(RequestPhotoSession $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => true,
                'order'     => [[0, 'desc']],
                'buttons'   => [],
            ]);
    }

    /**
     * Get columns.
     */
    protected function getColumns()
    {
        return [
            'id',
            'user_name',
            'phone',
            'email',
            'address',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'request_photo_sessions_' . time();
    }
}
