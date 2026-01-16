<?php

namespace App\Repositories;

use App\Models\offer_type;
use App\Repositories\BaseRepository;

/**
 * Class offer_typeRepository
 * @package App\Repositories
 * @version July 4, 2021, 10:23 am UTC
*/

class offer_typeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'type_offer'
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
        return offer_type::class;
    }
}
