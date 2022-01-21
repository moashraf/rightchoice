<?php

namespace App\Repositories;

use App\Models\SettingSite;
use App\Repositories\BaseRepository;

/**
 * Class SettingSiteRepository
 * @package App\Repositories
 * @version July 27, 2021, 12:11 pm UTC
*/

class SettingSiteRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'Title',
        'Address',
        'Mobile',
        'Phone _land_line',
        'mail',
        'facebook',
        'linkedin',
        'insta',
        'tiwiter',
        'youtube',
        'map_link',
        'meta_title',
        'meta_keyword',
        'meta_description',
        'logo',
        'icon',
        'short_dis_about',
        'whatsapp',
        'featured_ads_dis',
        'estate_sale_dis',
        'estate_sale_rent',
        'services_dis',
        'most_searched_dis',
        'connect_us_dis'
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
        return SettingSite::class;
    }
}
