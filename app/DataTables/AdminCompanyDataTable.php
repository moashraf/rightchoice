<?php

namespace App\DataTables;

use App\Models\Company;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminCompanyDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_companies.datatables_actions')
            ->editColumn('status', function ($row) {
                return $row->status == 1
                    ? '<span class="badge badge-success">Active</span>'
                    : '<span class="badge badge-danger">UnActive</span>';
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Company $model)
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
            'Name',
            'Phone',
            'status',
        ];
    }

    protected function filename(): string
    {
        return 'admin_companies_datatable_' . time();
    }
}
