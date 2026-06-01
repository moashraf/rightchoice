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
                    ? '<span class="badge badge-success">نشطة</span>'
                    : '<span class="badge badge-danger">غير نشطة</span>';
            })
            ->addColumn('governrate', function ($row) {
                return $row->governrateq ? $row->governrateq->governrate." ". $row->district_data->district : '-';
            })
            ->addColumn('service', function ($row) {
                return $row->serv ? $row->serv->Service : '-';
            })
            ->rawColumns(['action', 'status']);
    }

    public function query(Company $model)
    {
        $query = $model->newQuery()->with(['governrateq', 'serv']);

        if ($name = request('filter_name')) {
            $query->where('Name', 'like', '%' . $name . '%');
        }
        if ($gov = request('filter_governrate')) {
            $query->where('governrate_id', $gov);
        }
        if ($dist = request('filter_district')) {
            $query->where('district_id', $dist);
        }
        if ($serv = request('filter_service')) {
            $query->where('Serv_id', $serv);
        }
        if (request('filter_status') !== null && request('filter_status') !== '') {
            $query->where('status', request('filter_status'));
        }

        return $query;
    }

    public function html()
    {
        // Bake current filter params into the AJAX URL so pagination/sorting keep filters
        $params = request()->only(['filter_name', 'filter_governrate', 'filter_district', 'filter_service', 'filter_status']);
        $ajaxUrl = route('sitemanagement.companies.index') . (count(array_filter($params)) ? '?' . http_build_query($params) : '');

        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax($ajaxUrl)
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrtip',
                'stateSave' => false,
                'order'     => [[0, 'desc']],
                'buttons'   => [],
            ]);
    }

    protected function getColumns()
    {
        return [
            ['data' => 'id',          'name' => 'id',          'title' => '#'],
            ['data' => 'Name',        'name' => 'Name',        'title' => 'اسم الشركة'],
            ['data' => 'Phone',       'name' => 'Phone',       'title' => 'الهاتف'],
            ['data' => 'governrate',  'name' => 'governrateq.governrate', 'title' => 'المحافظة', 'searchable' => false, 'orderable' => false],
            ['data' => 'service',     'name' => 'serv.service',           'title' => 'الخدمة',   'searchable' => false, 'orderable' => false],
            ['data' => 'status',      'name' => 'status',      'title' => 'الحالة'],
        ];
    }

    protected function filename(): string
    {
        return 'admin_companies_datatable_' . time();
    }
}
