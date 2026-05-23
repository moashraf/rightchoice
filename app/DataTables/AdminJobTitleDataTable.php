<?php

namespace App\DataTables;

use App\Models\JobTitles;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class AdminJobTitleDataTable extends DataTable
{
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable->addColumn('action', 'admin_job_titles.datatables_actions');
    }

    public function query(JobTitles $model)
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
            'Job_title' => ['title' => 'المسمى الوظيفي'],
            'Job_title_en' => ['title' => 'Job Title (English)'],
            'created_at' => ['title' => 'تاريخ الإنشاء'],
            'updated_at' => ['title' => 'آخر تحديث'],
        ];
    }

    protected function filename(): string
    {
        return 'admin_job_titles_datatable_' . time();
    }
}
