<?php

namespace App\DataTables;

use App\Models\Mzaya;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminMzayaDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_mzayas.datatables_actions')
            ->addColumn('image', function ($row) {
                if ($row->img_name) {
                    return '<img src="' . asset('uploads/mzaya/' . $row->img_name) . '" height="50"/>';
                }
                return '';
            })
            ->rawColumns(['action', 'image']);
    }

    public function query(Mzaya $model)
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
            'mzaya_type',
        ];
    }

    protected function filename(): string
    {
        return 'admin_mzayas_datatable_' . time();
    }
}
