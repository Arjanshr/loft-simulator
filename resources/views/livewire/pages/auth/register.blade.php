<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    @if ($errors->any())
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" 
             class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-xl shadow-2xl font-bold font-industrial">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>⚠ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2 class="font-industrial text-2xl font-black text-white text-center mb-8 uppercase tracking-widest italic text-yellow-500">Recruitment</h2>

    <form wire:submit="register" class="space-y-4">

        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 ml-1">Operator Name</label>
            <input wire:model="name" type="text" required autofocus
                   class="w-full bg-black/50 border-2 border-slate-800 rounded-xl p-3 text-white placeholder-slate-700 focus:border-yellow-500 transition-all font-bold text-sm">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 ml-1">Email Address</label>
            <input wire:model="email" type="email" required
                   class="w-full bg-black/50 border-2 border-slate-800 rounded-xl p-3 text-white placeholder-slate-700 focus:border-yellow-500 transition-all font-bold text-sm">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 ml-1">Secure Key</label>
            <input wire:model="password" type="password" required
                   class="w-full bg-black/50 border-2 border-slate-800 rounded-xl p-3 text-white placeholder-slate-700 focus:border-yellow-500 transition-all font-bold text-sm">
        </div>

        <div>
            <label class="block text-[10px] font-black text-slate-500 uppercase tracking-widest mb-1 ml-1">Confirm Key</label>
            <input wire:model="password_confirmation" type="password" required
                   class="w-full bg-black/50 border-2 border-slate-800 rounded-xl p-3 text-white placeholder-slate-700 focus:border-yellow-500 transition-all font-bold text-sm">
        </div>

        <div class="pt-4">
            <button type="submit" 
                    class="w-full py-4 bg-yellow-500 hover:bg-yellow-400 text-black font-industrial font-black text-lg rounded-2xl transition-all shadow-xl shadow-yellow-500/20 active:scale-[0.98] uppercase">
                Establish Loft
            </button>
        </div>
    </form>
    
    <div class="mt-8 pt-6 border-t border-slate-800 text-center">
        <p class="text-slate-500 text-xs font-bold uppercase tracking-widest">
            Already verified? <a href="{{ route('login') }}" class="text-yellow-500 hover:text-yellow-400 underline decoration-2 underline-offset-4 ml-1">Login</a>
        </p>
    </div>
</div>
