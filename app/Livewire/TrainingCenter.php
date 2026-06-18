<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Pigeon;
use App\Services\PigeonService;
use Illuminate\Support\Facades\Auth;

class TrainingCenter extends Component
{
    public $selectedPigeonIds = [];
    public $statGains = [];
    public $restCost;

    public function mount()
    {
        $this->restCost = config('game.training.rest_cost', 50);
    }

    public function toggleSelectAll()
    {
        $userLoft = Auth::user()->loft;
        $allIds = $userLoft->pigeons()
            ->where('status', 'idle')
            ->pluck('id')
            ->map(fn($id) => (string)$id)
            ->toArray();

        $allSelected = count($allIds) > 0 && count(array_diff($allIds, $this->selectedPigeonIds)) === 0;

        if ($allSelected) {
            $this->selectedPigeonIds = [];
        } else {
            $this->selectedPigeonIds = $allIds;
        }
    }

    public function train($type)
    {
        if (empty($this->selectedPigeonIds)) {
            session()->flash('error', 'Please select at least one pigeon.');
            return;
        }

        $userLoft = Auth::user()->loft;
        $this->statGains = [];
        $points = rand(1, 5);
        $energyCost = config('game.training.energy_cost', 20);
        $thresholdMultiplier = config('game.training.stat_threshold_multiplier', 10);

        foreach ($this->selectedPigeonIds as $pigeonId) {
            $pigeon = Pigeon::findOrFail($pigeonId);

            if ((int)$pigeon->loft_id !== (int)$userLoft->id) continue;

            $intelligenceBonus = $pigeon->intelligence / config('game.training.intelligence_divisor', 20);
            $maxGain = $points + $intelligenceBonus + ($pigeon->level * config('game.training.level_gain_multiplier', 1.5));
            $minGain = (int)$pigeon->level;
            
            $cost = config('game.training.base_coin_cost', 100) + ($pigeon->beauty * config('game.training.beauty_multiplier', 10));

            switch ($type) {
                case 'flight':
                case 'distance':
                    if ($pigeon->energy < $energyCost) continue 2;

                    $statsToTrain = $type === 'flight' 
                        ? ['endurance', 'temperament', 'loyalty'] 
                        : ['speed', 'navigation', 'loyalty'];
                    
                    $anyStatTrained = false;
                    $statToForce = $statsToTrain[array_rand($statsToTrain)];

                    foreach ($statsToTrain as $stat) {
                        $limit = $pigeon->level * $thresholdMultiplier;
                        if ($pigeon->{$stat} >= $limit) continue;

                        if ($stat === $statToForce || rand(0, 1)) {
                            $gain = rand((int)$minGain, (int)ceil($maxGain));
                            $newVal = min($limit, $pigeon->{$stat} + $gain);
                            $actualGain = $newVal - $pigeon->{$stat};
                            
                            if ($actualGain > 0) {
                                $pigeon->increment($stat, $actualGain);
                                $this->statGains[$pigeonId][$stat] = $actualGain;
                                $anyStatTrained = true;
                            }
                        }
                    }

                    if ($anyStatTrained) {
                        $pigeon->decrement('energy', $energyCost);

                        // Lost Bird Mechanic: Only for Flight/Distance
                        if ($pigeon->loyalty < 20) {
                            $lostChance = (20 - $pigeon->loyalty) * 1.5;
                            if (rand(1, 100) <= $lostChance) {
                                $randomLoft = \App\Models\Loft::where('id', '!=', $userLoft->id)->inRandomOrder()->first();
                                if ($randomLoft) {
                                    $pigeon->update([
                                        'status' => 'lost',
                                        'lost_at' => now(),
                                        'stray_at_loft_id' => $randomLoft->id
                                    ]);

                                    // Cleanup: Disband any active pairs
                                    \App\Models\Pair::where('is_active', true)
                                        ->where(function($q) use ($pigeon) {
                                            $q->where('male_id', $pigeon->id)->orWhere('female_id', $pigeon->id);
                                        })->update(['is_active' => false]);

                                    // Cleanup: Cancel any active listings
                                    \App\Models\Listing::where('pigeon_id', $pigeon->id)
                                        ->where('is_active', true)
                                        ->update(['is_active' => false]);

                                    (new \App\Services\ActivityService())->log($userLoft, "ALERT: {$pigeon->name} got lost during training and was last seen flying toward another sector!");
                                    $this->selectedPigeonIds = array_diff($this->selectedPigeonIds, [$pigeon->id]);
                                    session()->flash('error', "CRITICAL: {$pigeon->name} has gone missing during the training exercise!");
                                }
                            }
                        }
                    } else {
                        session()->flash('error', "Some pigeons have reached their Lv.{$pigeon->level} training limit!");
                    }
                    break;

                case 'grooming':
                case 'physical_care':
                case 'gene_therapy':
                    if ($userLoft->coins < $cost) continue 2;
                    
                    if ($type === 'grooming') {
                        $totalPoints = rand((int)$minGain, (int)ceil($maxGain));
                        $attributes = ['feather_quality', 'color', 'pattern'];
                        $anyAttrTrained = false;

                        foreach($attributes as $attr) {
                            $limit = $pigeon->level * $thresholdMultiplier;
                            if ($pigeon->{$attr} >= $limit) continue;

                            $attrGains = 0;
                            for ($i = 0; $i < $totalPoints; $i++) {
                                if($attributes[array_rand($attributes)] == $attr) {
                                    $attrGains++;
                                }
                            }

                            if($attrGains > 0) {
                                $newVal = min($limit, $pigeon->{$attr} + $attrGains);
                                $actualGain = $newVal - $pigeon->{$attr};
                                if ($actualGain > 0) {
                                    $pigeon->increment($attr, $actualGain);
                                    $this->statGains[$pigeonId][$attr] = $actualGain;
                                    $anyAttrTrained = true;
                                }
                            }
                        }
                        if ($anyAttrTrained) $userLoft->decrement('coins', $cost);
                    } elseif ($type === 'physical_care') {
                        $attrPool = ['eyes', 'beak', 'legs'];
                        $attr = $attrPool[rand(0,2)];
                        $limit = $pigeon->level * $thresholdMultiplier;
                        
                        if ($pigeon->{$attr} < $limit) {
                            $gain = rand((int)$minGain, (int)ceil($maxGain));
                            $newVal = min($limit, $pigeon->{$attr} + $gain);
                            $actualGain = $newVal - $pigeon->{$attr};
                            
                            if ($actualGain > 0) {
                                $pigeon->increment($attr, $actualGain);
                                $this->statGains[$pigeonId][$attr] = $actualGain;
                                $userLoft->decrement('coins', $cost);
                            }
                        }
                    } else {
                        $limit = $pigeon->level * $thresholdMultiplier;
                        if ($pigeon->purity < $limit) {
                            $gain = rand((int)$minGain, (int)ceil($maxGain));
                            $newVal = min($limit, $pigeon->purity + $gain);
                            $actualGain = $newVal - $pigeon->purity;

                            if ($actualGain > 0) {
                                $pigeon->increment('purity', $actualGain);
                                $this->statGains[$pigeonId]['purity'] = $actualGain;
                                $userLoft->decrement('coins', $cost);
                            }
                        }
                    }
                    break;
            }
            $pigeon->update(['last_trained_at' => now()]);
        }

        $this->dispatch('loft-updated');
        session()->flash('message', 'Batch training complete!');
    }

    public function levelUp($pigeonId, PigeonService $pigeonService)
    {
        $userLoft = Auth::user()->loft;
        $pigeon = $userLoft->pigeons()->findOrFail($pigeonId);

        // Constraint: Pigeon level cannot exceed Loft level
        if ($pigeon->level >= $userLoft->level) {
            session()->flash('error', "Upgrade your Loft to level up {$pigeon->name} further!");
            return;
        }

        if ($pigeonService->levelUpPigeon($pigeon)) {
            $this->dispatch('loft-updated');
            session()->flash('message', "{$pigeon->name} leveled up to Lv.{$pigeon->level}!");
        } else {
            session()->flash('error', "Not enough training stats to level up.");
        }
    }

    public function restAll(PigeonService $pigeonService)
    {
        $userLoft = Auth::user()->loft;
        foreach ($this->selectedPigeonIds as $pigeonId) {
            $pigeon = $userLoft->pigeons()->findOrFail($pigeonId);
            // PigeonService::instantRest already handles the vitamin decrement and energy update
            if ($pigeonService->instantRest($pigeon)) {
                // Success
            }
        }
        $this->dispatch('loft-updated');
        session()->flash('message', 'Selected pigeons rested!');
    }

    public function render()
    {
        $userLoft = Auth::user()->loft;
        $pigeons = $userLoft->pigeons()->where('status', 'idle')->get();
        $selectedPigeons = $userLoft->pigeons()->whereIn('id', $this->selectedPigeonIds)->get();
        
        $totalCost = $selectedPigeons->sum(fn($p) => 100 + ($p->beauty * 10));

        return view('livewire.training-center', [
            'pigeons' => $pigeons,
            'selectedPigeons' => $selectedPigeons,
            'totalCost' => $totalCost,
        ])->layout('layouts.app', ['header' => 'Training Center']);
    }
}
