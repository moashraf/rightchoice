<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class blog
 * @package App\Models
 * @version July 1, 2021, 1:11 pm UTC
 *
 * @property string $seo_title
 * @property integer $status
 * @property string $main_img_alt
 * @property string $single_photo
 * @property integer $sort_num
 * @property string $meta_description
 * @property integer $number_of_visits
 * @property string $title
 * @property string $description
 * @property string $slug
 * @property string $canonical
 * @property string $created_at
 * @property string $updated_at
 */
class blog extends Model
{


    public $table = 'blogs';
    



    public $fillable = [
        'seo_title',
        'status',
        'main_img_alt',
        'single_photo',
        'sort_num',
        'meta_description',
        'number_of_visits',
        'title',
        'description',
        'slug',
        'canonical',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'seo_title' => 'string',
        'status' => 'integer',
        'main_img_alt' => 'string',
        'single_photo' => 'string',
        'sort_num' => 'integer',
        'number_of_visits' => 'integer',
        'title' => 'string',
        'slug' => 'string',
        'canonical' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */

    public function errorMessages()
    {
        return
            [

            ];
    }

    
}
