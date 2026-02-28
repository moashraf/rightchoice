<?php

namespace App\DataTables;

use App\Models\SettingSite;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminSettingSiteDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_setting_sites.datatables_actions')
            ->editColumn('logo', function ($settingSite) {
                if (!empty($settingSite->logo)) {
                    return '<a href="' . url($settingSite->logo) . '" data-toggle="lightbox"><img src="' . url($settingSite->logo) . '" height="50" class="img-thumbnail"/></a>';
                }
                return '-';
            })
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(SettingSite $model)
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
            'Title',
            'Address',
            'Mobile',
            'mail',
            'logo',
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'setting_sites_' . time();
    }
}
