<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use App\Services\GameSettingsService;

use App\Models\Loft;
use App\Models\ActivityLog;
use App\Models\Race;

class AdminDashboard extends Component
{
    public $settings = [];
    public $selectedAiLoftId = null;

    // Race management
    public $races = [];
    public $editingRaceId = null;
    public $raceForm = [
        'title' => '',
        'race_type' => 'racing',
        'distance_km' => 100,
        'difficulty_tier' => 1,
        'entry_fee' => 0,
        'prize_pool' => 0,
        'level_requirement' => 1,
    ];

    public function mount(GameSettingsService $settingsService)
    {
        if (!Auth::user()->is_admin) {
            abort(403);
        }
        
        $this->settings = [
            'breeding_cost' => $settingsService->get('breeding_cost', 100),
            'training_energy_cost' => $settingsService->get('training_energy_cost', 20),
            'aesthetic_upgrade_base_cost' => $settingsService->get('aesthetic_upgrade_base_cost', 50),
            'ai_lost_birds_per_human_per_hour' => $settingsService->get('ai_lost_birds_per_human_per_hour', 0.2),
        ];
    }

    public function selectAiLoft($id)
    {
        $this->selectedAiLoftId = $id;
    }

    // ── Race Management ──────────────────────────────────────────────

    public function loadRaces()
    {
        $this->races = Race::orderBy('level_requirement')->get()->toArray();
    }

    public function resetRaceForm()
    {
        $this->editingRaceId = null;
        $this->raceForm = [
            'title' => '',
            'race_type' => 'racing',
            'distance_km' => 100,
            'difficulty_tier' => 1,
            'entry_fee' => 0,
            'prize_pool' => 0,
            'level_requirement' => 1,
        ];
    }

    public function editRace($id)
    {
        $race = Race::findOrFail($id);
        $this->editingRaceId = $race->id;
        $this->raceForm = [
            'title' => $race->title,
            'race_type' => $race->race_type,
            'distance_km' => $race->distance_km,
            'difficulty_tier' => $race->difficulty_tier,
            'entry_fee' => $race->entry_fee,
            'prize_pool' => $race->prize_pool,
            'level_requirement' => $race->level_requirement,
        ];
    }

    public function saveRace()
    {
        $this->validate([
            'raceForm.title' => 'required|string|max:255',
            'raceForm.race_type' => 'required|in:racing,exhibition,highflyer',
            'raceForm.distance_km' => 'required|integer|min:1',
            'raceForm.difficulty_tier' => 'required|integer|min:1',
            'raceForm.entry_fee' => 'required|integer|min:0',
            'raceForm.prize_pool' => 'required|integer|min:0',
            'raceForm.level_requirement' => 'required|integer|min:1',
        ]);

        if ($this->editingRaceId) {
            Race::findOrFail($this->editingRaceId)->update($this->raceForm);
            session()->flash('message', 'Tournament updated successfully.');
        } else {
            Race::create($this->raceForm);
            session()->flash('message', 'Tournament created successfully.');
        }

        $this->resetRaceForm();
        $this->loadRaces();
    }

    public function deleteRace($id)
    {
        Race::findOrFail($id)->delete();
        $this->resetRaceForm();
        $this->loadRaces();
        session()->flash('message', 'Tournament deleted successfully.');
    }

    public function cancelRaceEdit()
    {
        $this->resetRaceForm();
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
        $this->loadRaces();

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
