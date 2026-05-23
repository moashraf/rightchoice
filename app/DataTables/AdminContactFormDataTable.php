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

        return $dataTable
            ->editColumn('user_id', function ($contactForm) {
                if (!$contactForm->user_id) {
                    return '-';
                }

                $label = $contactForm->user ? $contactForm->user->name : ('مستخدم #' . $contactForm->user_id);
                $url = route('sitemanagement.users.show', $contactForm->user_id);

                return '<a href="' . e($url) . '" target="_blank">' . e($label) . '</a>';
            })
            ->addColumn('action', 'admin_contact_forms.datatables_actions')
            ->rawColumns(['user_id', 'action']);
    }

    public function query(ContactForm $model)
    {
        return $model->newQuery()->with('user');
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
            'user_id' => ['title' => 'المستخدم'],
            'subject',
        ];
    }

    protected function filename(): string
    {
        return 'contact_forms_' . date('YmdHis');
    }
}
