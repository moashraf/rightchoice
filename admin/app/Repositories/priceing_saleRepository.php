<?php

namespace App\Repositories;

use App\Models\priceing_sale;
use App\Repositories\BaseRepository;

/**
 * Class priceing_saleRepository
 * @package App\Repositories
 * @version July 11, 2021, 12:33 pm UTC
*/

class priceing_saleRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type',
        'description',
        'price',
        'points',
        'desc1',
        'desc2',
        'desc3',
        'color',
        'title_color',
        'bk_color'
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
        return priceing_sale::class;
    }
}
