<?php

namespace App\DataTables;

use App\Models\aqar;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class aqarDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'aqars.datatables_actions')
        ->editColumn('created_at', function ($request) {
            return $request->created_at->toDayDateTimeString();
        })
        ->editColumn('status', function ($request) {
            if($request->status == 1){
                $status = '<span class="badge badge-success">Active</span>';
            }else{
                $status = '<span class="badge badge-danger">UnActive</span>';
            }
            return $status;
        })
        ->editColumn('vip', function ($request) {
            if($request->vip == 1){
                $vip = '<i class="fas fa-check" style="font-size: larger;color: green;"></i>';
            }else{
                $vip = '<i class="fas fa-times" style="font-size: larger;color: red;"></i>';
            }
            return $vip;
            
        })
        ->editColumn('total_price', function ($request) {
            if($request->offer_type == 3 || $request->offer_type == 4){
                $total_price = $request->monthly_rent;
            }else{
                $total_price = $request->total_price;
            }
            return $total_price;
        })
        ->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\aqar $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(aqar $model)
    {
        return $model->newQuery()->with(['category','property','offertype']);
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
            'title',
            'cat_id' => new \Yajra\DataTables\Html\Column(['title' => 'Category', 'data' => 'category.category_name', 'name' => 'category.category_name']),
            'property_type' => new \Yajra\DataTables\Html\Column(['title' => 'Property', 'data' => 'property.property_type', 'name' => 'property.property_type']),
            'offer_type' => new \Yajra\DataTables\Html\Column(['title' => 'Type', 'data' => 'offertype.type_offer', 'name' => 'offertype.type_offer']),
            'total_price' => ['title' => 'Price', 'data' => 'total_price'],
            'vip',
            'views',
            'status',
            'created_at',
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'aqars_datatable_' . time();
    }
}
