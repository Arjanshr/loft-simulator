<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/race/{raceId}/{pigeonId}', \App\Livewire\LiveRace::class)
    ->middleware(['auth', 'verified'])
    ->name('race.live');

require __DIR__.'/auth.php';
