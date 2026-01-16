<?php

namespace App\DataTables;

use App\Models\Complaints;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class ComplaintsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'complaints.datatables_actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Complaints $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Complaints $model)
    {
        return $model->newQuery()->with(['userinfo','aqarinfo']);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
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
                'buttons'   => [
                    // ['extend' => 'create', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'export', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'print', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'reset', 'className' => 'btn btn-default btn-sm no-corner',],
                    // ['extend' => 'reload', 'className' => 'btn btn-default btn-sm no-corner',],
                ],
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'id',
            'user_id' => new \Yajra\DataTables\Html\Column(['title' => 'User Name', 'data' => 'userinfo.name', 'name' => 'userinfo.name']),
            'aqar_id' => new \Yajra\DataTables\Html\Column(['title' => 'Aqar Name', 'data' => 'aqarinfo.title', 'name' => 'aqarinfo.title']),
            'time' => new \Yajra\DataTables\Html\Column(['title' => 'Time', 'data' => 'created_at', 'time' => 'created_at'])
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'complaints_datatable_' . time();
    }
}
