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

<div class="min-h-screen bg-slate-900 flex flex-col justify-center items-center">
    <div class="w-full max-w-md bg-slate-800 p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-black text-white mb-6">Welcome Back</h2>
        
        <form wire:submit="login">
            @if ($errors->any())
                <div class="mb-4 text-red-400 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="mb-4">
                <label class="block text-gray-400 mb-2">Email</label>
                <input wire:model="form.email" type="email" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-6">
                <label class="block text-gray-400 mb-2">Password</label>
                <input wire:model="form.password" type="password" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-500">Log In</button>
        </form>
        
        <p class="text-center text-gray-400 mt-6">
            Don't have a loft? <a href="{{ route('register') }}" class="text-indigo-400 hover:underline">Register</a>
        </p>
    </div>
</div>
