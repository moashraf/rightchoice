<?php

namespace App\DataTables;

use App\Models\aqar_category;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminAqarCategoryDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_aqar_categories.datatables_actions');
    }

    public function query(aqar_category $model)
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
            'category_name',
            'category_name_en',
        ];
    }

    protected function filename(): string
    {
        return 'admin_aqar_categories_datatable_' . time();
    }
}
