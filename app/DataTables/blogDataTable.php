<?php

namespace App\DataTables;

use App\Models\blog;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class blogDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'blogs.datatables_actions')
        ->editColumn('created_at', function ($request) {
            return $request->created_at->toDayDateTimeString();
        })
        ->editColumn('status', function ($request) {
            if($request->status == 0){
                $status = '<span class="badge badge-success">Active</span>';
            }else{
                $status = '<span class="badge badge-danger">UnActive</span>';
            }
            return $status;
        })->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\blog $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(blog $model)
    {
        return $model->newQuery();
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
            'Main Img' => ['name' => 'Main Img', 'data' => 'main_img_alt', 'render' => '"<a href=\""+data+"\" data-toggle=\"lightbox\"/><img src=\""+data+"\" height=\"50\"/>"'],
            'title',
            'number_of_visits',
            'created_at',
            'status'

        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'blogs_datatable_' . time();
    }
}
