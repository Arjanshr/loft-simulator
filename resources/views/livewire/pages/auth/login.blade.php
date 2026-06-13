<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <h2 class="font-industrial text-2xl font-black text-white text-center mb-8 uppercase tracking-widest italic">Authorization</h2>

    <form wire:submit="login" class="space-y-6">
        @if ($errors->any())
            <div class="p-4 bg-red-500/10 border border-red-500/50 rounded-2xl animate-pulse">
                <ul class="text-xs text-red-400 font-bold space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>⚠ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div>
            <label class="block text-xs font-black text-yellow-500 uppercase tracking-widest mb-2 ml-1">Terminal ID (Email)</label>
            <input wire:model="form.email" type="email" required autofocus
                   class="w-full bg-black/50 border-2 border-slate-700 rounded-2xl p-4 text-white placeholder-slate-600 focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/10 transition-all font-bold">
        </div>

        <div>
            <label class="block text-xs font-black text-yellow-500 uppercase tracking-widest mb-2 ml-1">Access Key (Password)</label>
            <input wire:model="form.password" type="password" required
                   class="w-full bg-black/50 border-2 border-slate-700 rounded-2xl p-4 text-white placeholder-slate-600 focus:border-yellow-500 focus:ring-4 focus:ring-yellow-500/10 transition-all font-bold">
        </div>

        <div class="flex items-center justify-between px-1">
            <label class="inline-flex items-center group cursor-pointer">
                <input wire:model="form.remember" type="checkbox" class="rounded border-slate-700 bg-black text-yellow-500 focus:ring-yellow-500/20">
                <span class="ms-2 text-xs font-bold text-slate-500 group-hover:text-slate-300 transition-colors uppercase">Maintain Uplink</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-xs font-bold text-slate-500 hover:text-yellow-500 transition-colors uppercase" href="{{ route('password.request') }}" wire:navigate>
                    Key Lost?
                </a>
            @endif
        </div>

        <button type="submit" 
                class="w-full py-4 bg-yellow-500 hover:bg-yellow-400 text-black font-industrial font-black text-lg rounded-2xl transition-all shadow-xl shadow-yellow-500/20 active:scale-[0.98] uppercase">
            Initialize Session
        </button>
    </form>
    
    <div class="mt-10 pt-8 border-t border-slate-800 text-center">
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">
            New operator? <a href="{{ route('register') }}" class="text-yellow-500 hover:text-yellow-400 underline decoration-2 underline-offset-4 ml-1">Establish Loft</a>
        </p>
    </div>
</div>
