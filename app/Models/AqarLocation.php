<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AqarLocation extends Model
{
    use HasFactory;

    protected $table = 'aqar_locations';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_aqar',
        'lat',
        'lon',
    ];

    protected $casts = [
        'lat' => 'float',
        'lon' => 'float',
    ];

    /**
     * The property this location belongs to.
     */
    public function aqar()
    {
        return $this->belongsTo(aqar::class, 'id_aqar');
    }

    /**
     * Validate that lat/lon are within valid ranges.
     */
    public static function isValidCoordinate($lat, $lon): bool
    {
        return is_numeric($lat) && is_numeric($lon)
            && $lat >= -90 && $lat <= 90
            && $lon >= -180 && $lon <= 180
            && ($lat != 0 || $lon != 0);
    }
}
