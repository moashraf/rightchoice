<?php

namespace App\Repositories;

use App\Models\PriceVip;
use App\Repositories\BaseRepository;

/**
 * Class PriceVipRepository
 * @package App\Repositories
 * @version July 15, 2021, 12:12 pm UTC
*/

class PriceVipRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'price',
        'description',
        'views'
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
        return PriceVip::class;
    }
}
