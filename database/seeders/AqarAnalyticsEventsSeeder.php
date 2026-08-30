<?php

namespace Database\Seeders;

use App\Models\aqar;
use App\Models\AqarAnalyticsEvent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Seeder اختياري لإنشاء بيانات تحليلية تجريبية خلال آخر 90 يومًا.
 *
 * التشغيل في بيئة التطوير فقط:
 *   php artisan db:seed --class=Database\\Seeders\\AqarAnalyticsEventsSeeder
 *
 * لا يشتغل تلقائيًا على Production لأن DatabaseSeeder لا يستدعيه.
 */
class AqarAnalyticsEventsSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->environment('production')) {
            $this->command?->warn('Aborting: analytics seeder is not allowed on production.');
            return;
        }

        $aqars = aqar::query()->where('status', 1)->limit(20)->get();
        if ($aqars->isEmpty()) {
            $this->command?->warn('لا توجد عقارات منشورة لإنشاء بيانات تحليلية عليها.');
            return;
        }

        $events = ['view', 'contact_reveal', 'whatsapp_click', 'favorite', 'comparison'];
        $now = Carbon::now();
        $created = 0;

        foreach ($aqars as $aqar) {
            for ($day = 0; $day < 90; $day++) {
                $date = $now->copy()->subDays($day);
                $dailyViews = random_int(1, 12);

                for ($v = 0; $v < $dailyViews; $v++) {
                    $when = $date->copy()
                        ->setHour(random_int(0, 23))
                        ->setMinute(random_int(0, 59))
                        ->setSecond(random_int(0, 59));

                    $visitorHash = hash('sha256', 'visitor-' . random_int(1, 500) . '-day-' . $day);

                    AqarAnalyticsEvent::create([
                        'aqar_id'      => $aqar->id,
                        'event_type'   => 'view',
                        'user_id'      => null,
                        'visitor_hash' => $visitorHash,
                        'source'       => 'seed',
                        'metadata'     => ['is_unique' => $v === 0],
                        'occurred_at'  => $when,
                    ]);
                    $created++;
                }

                foreach (['contact_reveal' => 2, 'whatsapp_click' => 2, 'favorite' => 2, 'comparison' => 2] as $type => $max) {
                    $count = random_int(0, $max);
                    for ($i = 0; $i < $count; $i++) {
                        AqarAnalyticsEvent::create([
                            'aqar_id'      => $aqar->id,
                            'event_type'   => $type,
                            'user_id'      => null,
                            'visitor_hash' => hash('sha256', 'v-' . random_int(1, 500) . $type),
                            'source'       => 'seed',
                            'metadata'     => null,
                            'occurred_at'  => $date->copy()->setHour(random_int(8, 22)),
                        ]);
                        $created++;
                    }
                }
            }
        }

        $this->command?->info("Created {$created} analytics events over the last 90 days.");
        Log::info('AqarAnalyticsEventsSeeder complete', ['created' => $created]);
    }
}
