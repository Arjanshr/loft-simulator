<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FAQ;

class FaqPage extends Component
{
    public function render()
    {
        return view('livewire.faq-page', [
            'faqs' => FAQ::orderBy('order')->get()->groupBy('category'),
        ])->layout('layouts.app', ['header' => 'Knowledge Base']);
    }
}
