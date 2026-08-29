<?php

namespace App\Console\Commands;

use App\Models\aqar;
use App\Models\PropertyPromotion;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ExpirePropertyPromotions extends Command
{
    protected $signature = 'promotions:expire';
    protected $description = 'Disable property promotions that reached their expiration time';

    public function handle(): int
    {
        $now = now();

        $expiredCount = DB::transaction(function () use ($now) {
            $flipped = aqar::query()
                ->where('vip', 1)
                ->whereNotNull('vip_expires_at')
                ->where('vip_expires_at', '<=', $now)
                ->update(['vip' => 0]);

            PropertyPromotion::query()
                ->where('status', PropertyPromotion::STATUS_ACTIVE)
                ->whereNotNull('expires_at')
                ->where('expires_at', '<=', $now)
                ->update(['status' => PropertyPromotion::STATUS_EXPIRED]);

            return $flipped;
        });

        $this->info("Expired {$expiredCount} property promotion(s).");

        return self::SUCCESS;
    }
}
