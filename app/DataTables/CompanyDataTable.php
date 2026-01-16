<?php

namespace App\DataTables;

use App\Models\Company;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class CompanyDataTable extends DataTable
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

        return $dataTable->addColumn('action', 'companies.datatables_actions')
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
        })->escapeColumns([]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Company $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Company $model)
    {
        return $model->newQuery()->with(['userinfo','governratinfo','districtinfo','serviceinfo']);
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
            'Photo' => ['name' => 'Photo', 'data' => 'photo', 'render' => '"<a href=\"images/"+data+"\" data-toggle=\"lightbox\"/><img src=\"https://rightchoice-co.com/public/images/"+data+"\" height=\"50\"/>"'],
            'Name',
            'user_id' => new \Yajra\DataTables\Html\Column(['title' => 'User', 'data' => 'userinfo.name', 'name' => 'userinfo.name']),
            'governrate_id' => new \Yajra\DataTables\Html\Column(['title' => 'Governrate', 'data' => 'governratinfo.governrate', 'name' => 'governratinfo.governrate']),
            'district_id' => new \Yajra\DataTables\Html\Column(['title' => 'District', 'data' => 'districtinfo.district', 'name' => 'districtinfo.district']),
            'Serv_id' => new \Yajra\DataTables\Html\Column(['title' => 'Service', 'data' => 'serviceinfo.Service', 'name' => 'serviceinfo.Service']),
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
        return 'companies_datatable_' . time();
    }
}
