<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('promotions:expire')->everyMinute()->withoutOverlapping();
        $lastPropertySuspensionRunKey = 'scheduler.properties_suspend_expired.last_success_at';

        $schedule->command('properties:suspend-expired')
            ->everyMinute()
            ->when(function () use ($lastPropertySuspensionRunKey) {
                $lastRunAt = Cache::get($lastPropertySuspensionRunKey);

                return $lastRunAt === null
                    || now()->timestamp - (int) $lastRunAt >= 20 * 60 * 60;
            })
            ->onSuccess(function () use ($lastPropertySuspensionRunKey) {
                Cache::forever($lastPropertySuspensionRunKey, now()->timestamp);
            })
            ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
