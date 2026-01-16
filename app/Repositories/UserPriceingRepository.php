<?php

namespace App\Repositories;

use App\Models\UserPriceing;
use App\Repositories\BaseRepository;

/**
 * Class UserPriceingRepository
 * @package App\Repositories
 * @version July 15, 2021, 2:16 pm UTC
*/

class UserPriceingRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'user_id',
        'pricing_id',
        'start_points',
        'current_points',
        'sub_points',
        'statues'
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
        return UserPriceing::class;
    }
}
