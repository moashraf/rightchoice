<?php

namespace App\Console\Commands;

use App\Services\PropertyAutoSuspensionService;
use Illuminate\Console\Command;

class SuspendExpiredProperties extends Command
{
    protected $signature = 'properties:suspend-expired';
    protected $description = 'Suspend published non-featured properties after 180 days';

    public function handle(PropertyAutoSuspensionService $service): int
    {
        $suspendedCount = $service->suspendExpiredProperties();

        $this->info("Suspended {$suspendedCount} expired property/properties.");

        return self::SUCCESS;
    }
}
