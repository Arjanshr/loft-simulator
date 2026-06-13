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

<div class="min-h-screen bg-slate-900 flex flex-col justify-center items-center">
    <div class="w-full max-w-md bg-slate-800 p-8 rounded-2xl shadow-xl">
        <h2 class="text-3xl font-black text-white mb-6">Create Your Loft</h2>
        
        <form wire:submit="register">
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
                <label class="block text-gray-400 mb-2">Name</label>
                <input wire:model="name" type="text" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-400 mb-2">Email</label>
                <input wire:model="email" type="email" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-4">
                <label class="block text-gray-400 mb-2">Password</label>
                <input wire:model="password" type="password" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-indigo-500">
            </div>
            <div class="mb-6">
                <label class="block text-gray-400 mb-2">Confirm Password</label>
                <input wire:model="password_confirmation" type="password" class="w-full bg-slate-900 border border-slate-700 rounded-lg p-3 text-white focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit" class="w-full bg-indigo-600 text-white font-bold py-3 rounded-lg hover:bg-indigo-500">Register</button>
        </form>
        
        <p class="text-center text-gray-400 mt-6">
            Already have a loft? <a href="{{ route('login') }}" class="text-indigo-400 hover:underline">Log In</a>
        </p>
    </div>
</div>
