<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('pigeons:mature')->hourly();
Schedule::command('pigeons:market-tick')->everyFiveMinutes();
Schedule::command('pigeons:passive-income')->everyMinute();
Schedule::command('pigeons:recover-energy')->everyTwoMinutes();
