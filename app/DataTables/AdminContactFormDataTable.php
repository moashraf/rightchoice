<?php

namespace App\DataTables;

use App\Models\ContactForm;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminContactFormDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_contact_forms.datatables_actions');
    }

    public function query(ContactForm $model)
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
            'name',
            'phone',
            'email',
            'subject',
        ];
    }

    protected function filename(): string
    {
        return 'contact_forms_' . date('YmdHis');
    }
}
