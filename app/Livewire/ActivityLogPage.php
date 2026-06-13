<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;

class ActivityLogPage extends Component
{
    use WithPagination;

    public function render()
    {
        return view('livewire.activity-log-page', [
            'activities' => Auth::user()->loft->activityLogs()->latest()->paginate(20),
        ])->layout('layouts.app', ['header' => 'Activity Log']);
    }
}
