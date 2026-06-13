<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('pigeons:mature')->hourly();
Schedule::command('pigeons:market-tick')->hourly();
