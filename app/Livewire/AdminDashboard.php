<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Services\GameSettingsService;

use App\Models\Loft;
use App\Models\ActivityLog;

class AdminDashboard extends Component
{
    public $settings = [];
    public $selectedAiLoftId = null;

    public function mount(GameSettingsService $settingsService)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }
        
        $this->settings = [
            'breeding_cost' => $settingsService->get('breeding_cost', 100),
            'training_energy_cost' => $settingsService->get('training_energy_cost', 20),
            'aesthetic_upgrade_base_cost' => $settingsService->get('aesthetic_upgrade_base_cost', 50),
            'ai_lost_bird_chance' => $settingsService->get('ai_lost_bird_chance', 20),
        ];
    }

    public function selectAiLoft($id)
    {
        $this->selectedAiLoftId = $id;
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

    public function runPassiveIncome()
    {
        \Illuminate\Support\Facades\Log::info('Admin Passive Income Triggered');
        Artisan::call('pigeons:passive-income');
        session()->flash('message', 'Passive income distribution executed successfully.');
    }

    public function runEnergyRecovery()
    {
        \Illuminate\Support\Facades\Log::info('Admin Energy Recovery Triggered');
        Artisan::call('pigeons:recover-energy');
        session()->flash('message', 'Energy recovery sequence executed successfully.');
    }

    public function runProcessLostBirds()
    {
        \Illuminate\Support\Facades\Log::info('Admin Process Lost Birds Triggered');
        Artisan::call('pigeons:process-lost');
        session()->flash('message', 'Lost bird processing executed successfully.');
    }

    public function render()
    {
        $aiLofts = Loft::whereHas('user', function($q) {
            $q->where('is_ai', true);
        })->withCount('pigeons')->get();

        $totalAiSpecimens = $aiLofts->sum('pigeons_count');
        $totalAiCoins = $aiLofts->sum('coins');

        $selectedAiLoft = null;
        $aiLoftLogs = collect();
        if ($this->selectedAiLoftId) {
            $selectedAiLoft = Loft::with('pigeons')->find($this->selectedAiLoftId);
            $aiLoftLogs = ActivityLog::where('loft_id', $this->selectedAiLoftId)
                ->latest()
                ->limit(20)
                ->get();
        }

        return view('livewire.admin-dashboard', [
            'aiLofts' => $aiLofts,
            'selectedAiLoft' => $selectedAiLoft,
            'aiLoftLogs' => $aiLoftLogs,
            'totalAiSpecimens' => $totalAiSpecimens,
            'totalAiCoins' => $totalAiCoins,
        ])->layout('layouts.app', ['header' => 'Policy Desk']);
    }
}
