<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\Eloquent\Model;

class InvalidConfiguration extends Exception
{
    public static function modelIsNotValid(string $className): self
    {
        return new static("The given model class `{$className}` does not extend `".Model::class.'`');
    }
}
