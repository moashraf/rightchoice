<?php

namespace App\Repositories;

use App\Models\Ads;
use App\Repositories\BaseRepository;

/**
 * Class AdsRepository
 * @package App\Repositories
 */
class AdsRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'img',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Ads::class;
    }
}
