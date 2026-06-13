<?php

use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Schedule::command('pigeons:mature')->hourly();
Schedule::command('pigeons:market-tick')->hourly();

// Heartbeat: Run every minute to verify Cron is working
Schedule::call(function () {
    Log::info('Scheduler Heartbeat: Cron Job is active.');
})->everyMinute();
