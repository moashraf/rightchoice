<?php

namespace App\DataTables;

use App\Models\Ads;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminAdsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_ads.datatables_actions')
            ->editColumn('img', function ($ad) {
                if (!empty($ad->img)) {
                    return '<a href="' . url('images/' . $ad->img) . '" data-toggle="lightbox">
                    <img src="' . url('images/' . $ad->img) . '" height="100" width="100" class="img-thumbnail" alt="ad"/>
                    </a>';
                }
                return '-';
            })
            ->editColumn('name', function ($ad) {
                if (!empty($ad->name)) {
                    return '<a href="' . $ad->name . '" target="_blank">' . $ad->name . '</a>';
                }
                return '-';
            })
            ->editColumn('created_at', function ($ad) {
                return $ad->created_at ? $ad->created_at->format('Y-m-d H:i') : '-';
            })
            ->editColumn('updated_at', function ($ad) {
                return $ad->updated_at ? $ad->updated_at->format('Y-m-d H:i') : '-';
            })
            ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     */
    public function query(Ads $model)
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
            'name'       => ['title' => 'الرابط'],
            'img'        => ['title' => 'الصورة'],
            'created_at' => ['title' => 'تاريخ الإنشاء'],
            'updated_at' => ['title' => 'تاريخ التعديل'],
        ];
    }

    /**
     * Get filename for export.
     */
    protected function filename(): string
    {
        return 'ads_' . time();
    }
}
