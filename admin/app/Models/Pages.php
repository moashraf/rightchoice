<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class Pages
 * @package App\Models
 * @version July 13, 2021, 9:58 am UTC
 *
 * @property string $page_name
 * @property string $description
 */
class Pages extends Model
{


    public $table = 'pages';
    



    public $fillable = [
        'page_name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'page_name' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
