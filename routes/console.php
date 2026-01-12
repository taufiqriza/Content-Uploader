<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Queue Worker Schedule (Hostinger Shared Hosting Compatible)
|--------------------------------------------------------------------------
|
| Since Hostinger Premium doesn't support supervisor/daemon processes,
| we run the queue worker every minute via cron job.
|
| Add this to Hostinger Cron:
| * * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
|
*/

Schedule::command('queue:work --stop-when-empty --timeout=120 --tries=3')
    ->everyMinute()
    ->withoutOverlapping()
    ->runInBackground();

// Refresh tokens that are expiring soon (run daily)
Schedule::command('app:refresh-expiring-tokens')
    ->daily()
    ->at('02:00');

// Process scheduled content (check every 5 minutes)
Schedule::command('app:process-scheduled-content')
    ->everyFiveMinutes()
    ->withoutOverlapping();
