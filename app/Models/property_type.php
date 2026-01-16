<?php

namespace App\Models;

use Eloquent as Model;



/**
 * Class property_type
 * @package App\Models
 * @version July 4, 2021, 11:09 am UTC
 *
 * @property string $property_type
 */
class property_type extends Model
{


    public $table = 'property_type';
    



    public $fillable = [
        'property_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'property_type' => 'string',
        'cat_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function category()
    {
        return $this->belongsTo(aqar_category::class, 'cat_id');
    }

    
}
