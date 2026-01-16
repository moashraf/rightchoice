<?php

namespace App\Contracts;

use Closure;
use Spatie\Activitylog\EventLogBag;

interface LoggablePipe
{
    public function handle(EventLogBag $event, Closure $next): EventLogBag;
}
