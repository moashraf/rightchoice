<?php

namespace App\Repositories;

use App\Models\JobTitles;

class JobTitlesRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'Job_title',
        'Job_title_en',
    ];

    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    public function model()
    {
        return JobTitles::class;
    }
}
