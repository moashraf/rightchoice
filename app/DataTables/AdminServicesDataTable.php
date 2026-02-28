<?php

namespace App\DataTables;

use App\Models\services;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminServicesDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_services.datatables_actions')
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    return '<img src="' . asset('uploads/service/' . $row->image) . '" height="50"/>';
                }
                return '';
            })
            ->rawColumns(['action', 'image']);
    }

    public function query(services $model)
    {
        return $model->newQuery();
    }

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

    protected function getColumns()
    {
        return [
            'id',
            'image',
            'Service',
            'title',
        ];
    }

    protected function filename(): string
    {
        return 'admin_services_datatable_' . time();
    }
}
