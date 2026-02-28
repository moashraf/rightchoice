<?php

namespace App\DataTables;

use App\Models\Slider;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminSliderDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_sliders.datatables_actions')
            ->editColumn('image', function ($slider) {
                if (!empty($slider->image)) {
                    return '<a href="' . url($slider->image) . '" data-toggle="lightbox"><img src="' . url($slider->image) . '" height="60" class="img-thumbnail"/></a>';
                }
                return '-';
            })
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Slider $model)
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
            'title',
            'sub_title',
            'image',
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'sliders_' . time();
    }
}
