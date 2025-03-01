<?php

use Illuminate\Support\Facades\Schedule;

// Schedule::command('demo:seed')->everyTwoHours();
Schedule::command('app:assign-reservation-table')->hourly();

Schedule::command('app:trial-expire')->daily();
Schedule::command('app:license-expire')->daily();
Schedule::command('app:hide-cron-job-message')->everyMinute();

Schedule::command('queue:flush')->weekly();

// Schedule the queue:work command to run without overlapping and with 3 tries
Schedule::command('queue:work database --tries=3 --stop-when-empty')->withoutOverlapping();
