<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class aqar_category
 * @package App\Models
 * @version July 4, 2021, 11:24 am UTC
 *
 * @property string $category_name
 */
class aqar_category extends Model
{


    public $table = 'aqar_category';
    



    public $fillable = [
        'category_name'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'category_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
