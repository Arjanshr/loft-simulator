<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Services\GameSettingsService;

class AdminDashboard extends Component
{
    public $settings = [];

    public function mount(GameSettingsService $settingsService)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }
        
        $this->settings = [
            'breeding_cost' => $settingsService->get('breeding_cost', 100),
            'training_energy_cost' => $settingsService->get('training_energy_cost', 20),
            'aesthetic_upgrade_base_cost' => $settingsService->get('aesthetic_upgrade_base_cost', 50),
        ];
    }

    public function updateSettings(GameSettingsService $settingsService)
    {
        foreach ($this->settings as $key => $value) {
            $settingsService->set($key, $value);
        }
        
        session()->flash('message', 'Settings updated successfully.');
    }

    public function runMaturation()
    {
        \Illuminate\Support\Facades\Log::info('Admin Maturation Triggered');
        Artisan::call('pigeons:mature');
        session()->flash('message', 'Maturation command executed successfully.');
    }

    public function runMarketTick()
    {
        \Illuminate\Support\Facades\Log::info('Admin Market Tick Triggered');
        Artisan::call('pigeons:market-tick');
        session()->flash('message', 'Market ecosystem tick executed successfully.');
    }

    public function render()
    {
        return view('livewire.admin-dashboard')->layout('layouts.app', ['header' => 'Admin Panel']);
    }
}
