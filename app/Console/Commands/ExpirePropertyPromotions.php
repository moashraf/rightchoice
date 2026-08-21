<?php

namespace App\Console\Commands;

use App\Models\aqar;
use Illuminate\Console\Command;

class ExpirePropertyPromotions extends Command
{
    protected $signature = 'promotions:expire';
    protected $description = 'Disable property promotions that reached their expiration time';

    public function handle(): int
    {
        $expiredCount = aqar::query()
            ->where('vip', 1)
            ->whereNotNull('vip_expires_at')
            ->where('vip_expires_at', '<=', now())
            ->update(['vip' => 0]);

        $this->info("Expired {$expiredCount} property promotion(s).");

        return self::SUCCESS;
    }
}
