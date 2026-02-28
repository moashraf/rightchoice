<?php

namespace App\DataTables;

use App\Models\property_type;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminPropertyTypeDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'admin_property_types.datatables_actions')
            ->addColumn('category_name', function ($row) {
                return $row->category ? $row->category->category_name : '-';
            })
            ->rawColumns(['action']);
    }

    public function query(property_type $model)
    {
        return $model->newQuery()->with(['category']);
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
            'property_type',
            'property_type_en',
            'category_name' => ['title' => 'الفئة', 'data' => 'category_name', 'name' => 'category_name', 'searchable' => false, 'orderable' => false],
        ];
    }

    protected function filename(): string
    {
        return 'property_types_' . date('YmdHis');
    }
}
