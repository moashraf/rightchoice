<?php

namespace App\DataTables;

use App\Models\Notification;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminNotificationDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_notifications.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Notification $model)
    {
        return $model->newQuery()->with(['userinfo']);
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
            'title',
            'type',
            'status',
            'user_id' => new \Yajra\DataTables\Html\Column([
                'title' => 'User Name',
                'data'  => 'userinfo.name',
                'name'  => 'userinfo.name',
            ]),
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'notifications_' . date('YmdHis');
    }
}
