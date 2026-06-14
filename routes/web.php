<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::view('pigeons', 'pigeons')
    ->middleware(['auth', 'verified'])
    ->name('pigeons.index');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/race/{raceId}/{pigeonId}', \App\Livewire\LiveRace::class)
    ->middleware(['auth', 'verified'])
    ->name('race.live');

Route::view('leaderboard', 'leaderboard')
    ->middleware(['auth'])
    ->name('leaderboard');

Route::view('tournaments', 'tournaments')
    ->middleware(['auth'])
    ->name('tournaments');

Route::get('marketplace', \App\Livewire\Marketplace::class)
    ->middleware(['auth'])
    ->name('marketplace');

Route::get('activity-log', \App\Livewire\ActivityLogPage::class)
    ->middleware(['auth'])
    ->name('activity.log');

Route::get('admin', \App\Livewire\AdminDashboard::class)
    ->middleware(['auth'])
    ->name('admin');

Route::get('loft/{loftId}', \App\Livewire\PublicLoftView::class)
    ->middleware(['auth'])
    ->name('loft.view');

Route::get('faq', \App\Livewire\FaqPage::class)
    ->middleware(['auth'])
    ->name('faq');

Route::get('breeding-center', \App\Livewire\BreedingCenter::class)
    ->middleware(['auth'])
    ->name('breeding.center');

Route::get('training-center', \App\Livewire\TrainingCenter::class)
    ->middleware(['auth'])
    ->name('training.center');

require __DIR__.'/auth.php';
