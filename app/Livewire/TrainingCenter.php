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
    public $restCost = 50;

    public function train($type)
    {
        \Illuminate\Support\Facades\Log::info('Training initiated', ['type' => $type, 'pigeonIds' => $this->selectedPigeonIds]);
        if (empty($this->selectedPigeonIds)) {
            session()->flash('error', 'Please select at least one pigeon.');
            return;
        }

        $userLoft = Auth::user()->loft;
        \Illuminate\Support\Facades\Log::info('User loft', ['loftId' => $userLoft->id]);
        $this->statGains = [];
        $points = rand(1, 5);
        $energyCost = 20;

        foreach ($this->selectedPigeonIds as $pigeonId) {
            $pigeon = Pigeon::findOrFail($pigeonId);
            \Illuminate\Support\Facades\Log::info('Pigeon found', ['pigeonId' => $pigeonId, 'loftId' => $pigeon->loft_id]);

            if ($pigeon->loft_id !== $userLoft->id) {
                \Illuminate\Support\Facades\Log::warning('Pigeon not in user loft', ['pigeonId' => $pigeonId, 'pigeonLoftId' => $pigeon->loft_id, 'userLoftId' => $userLoft->id]);
                continue;
            }

            $intelligenceBonus = $pigeon->intelligence / 20;
            $maxGain = $points + $intelligenceBonus;
            
            $cost = 100 + ($pigeon->beauty * 10);

            switch ($type) {
                case 'flight':
                case 'distance':
                    if ($pigeon->energy < $energyCost) continue 2;
                    $pigeon->decrement('energy', $energyCost);

                    if ($type === 'flight') {
                        $statsToTrain = ['endurance', 'temperament', 'loyalty'];
                        $statToForce = $statsToTrain[array_rand($statsToTrain)];

                        foreach ($statsToTrain as $stat) {
                            if ($stat === $statToForce || rand(0, 1)) {
                                $gain = rand(1, ceil($maxGain)); // Ensure at least 1 point
                                $pigeon->increment($stat, $gain);
                                $this->statGains[$pigeonId][$stat] = $gain;
                            }
                        }
                    } else {
                        $statsToTrain = ['speed', 'navigation'];
                        $statToForce = $statsToTrain[array_rand($statsToTrain)];

                        foreach ($statsToTrain as $stat) {
                            if ($stat === $statToForce || rand(0, 1)) {
                                $gain = rand(1, ceil($maxGain)); // Ensure at least 1 point
                                $pigeon->increment($stat, $gain);
                                $this->statGains[$pigeonId][$stat] = $gain;
                            }
                        }
                    }
                    break;
                case 'grooming':
                case 'physical_care':
                case 'gene_therapy':
                    if ($userLoft->coins < $cost) continue 2;
                    $userLoft->decrement('coins', $cost);
                    
                    if ($type === 'grooming') {
                        $totalPoints = rand(1, ceil($maxGain)) * $pigeon->level;
                        $attributes = ['feather_quality', 'color', 'pattern'];
                        foreach($attributes as $attr) {
                            $attrGains = 0;
                            for ($i = 0; $i < $totalPoints; $i++) {
                                if($attributes[array_rand($attributes)] == $attr) {
                                    $attrGains++;
                                }
                            }
                            if($attrGains > 0) {
                                $pigeon->increment($attr, $attrGains);
                                $this->statGains[$pigeonId][$attr] = $attrGains;
                            }
                        }
                    } elseif ($type === 'physical_care') {
                        $attr = ['eyes', 'beak', 'legs'][rand(0,2)];
                        $gain = rand(1, ceil($maxGain));
                        $pigeon->increment($attr, $gain);
                        $this->statGains[$pigeonId][$attr] = $gain;
                    } else {
                        $gain = rand(1, ceil($maxGain));
                        $pigeon->increment('purity', $gain);
                        $this->statGains[$pigeonId]['purity'] = $gain;
                    }
                    break;
            }
            $pigeon->update(['last_trained_at' => now()]);
        }

        $this->dispatch('loft-updated');
        session()->flash('message', 'Batch training complete!');
    }

    public function restAll(PigeonService $pigeonService)
    {
        $userLoft = Auth::user()->loft;
        foreach ($this->selectedPigeonIds as $pigeonId) {
            $pigeon = $userLoft->pigeons()->findOrFail($pigeonId);
            if ($userLoft->coins >= $this->restCost) {
                if ($pigeonService->instantRest($pigeon)) {
                     $userLoft->decrement('coins', $this->restCost);
                }
            }
        }
        $this->dispatch('loft-updated');
        session()->flash('message', 'Selected pigeons rested!');
    }

    public function render()
    {
        $userLoft = Auth::user()->loft;
        $pigeons = $userLoft->pigeons()->get();
        $selectedPigeons = $userLoft->pigeons()->whereIn('id', $this->selectedPigeonIds)->get();
        
        $totalCost = $selectedPigeons->sum(fn($p) => 100 + ($p->beauty * 10));

        return view('livewire.training-center', [
            'pigeons' => $pigeons,
            'selectedPigeons' => $selectedPigeons,
            'totalCost' => $totalCost,
        ])->layout('layouts.app', ['header' => 'Training Center']);
    }
}
