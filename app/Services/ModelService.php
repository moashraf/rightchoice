<?php

namespace App\Services;

class ModelService
{

    public static function filter_search($model,$request)
    {
        return $model->paginate(10);
    }
}
