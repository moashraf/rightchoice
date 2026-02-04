<?php

namespace App\Contracts;

use Closure;

interface LoggablePipe
{
    public function handle(mixed $event, Closure $next): mixed;
}
