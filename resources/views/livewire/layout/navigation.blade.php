<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }

    /**
     * Optional: Method to handle polling tick if logic is needed, 
     * but wire:poll alone will refresh the properties.
     */
    public function refreshResources()
    {
        // Property refresh is automatic
    }
}; ?>

<div class="flex flex-col h-full bg-slate-950/50 backdrop-blur-2xl" wire:poll.60s="refreshResources">
    <!-- Brand Logo -->
    <div class="h-16 flex items-center px-8 border-b border-white/5 bg-black/20">
        <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-3 group">
            <div class="w-8 h-8 bg-yellow-500 rounded-lg flex items-center justify-center text-black shadow-[0_0_15px_rgba(234,179,8,0.3)] group-hover:scale-110 transition-transform">
                <span class="text-lg">🕊️</span>
            </div>
            <span class="font-industrial font-black text-white group-hover:text-yellow-500 tracking-tighter text-sm italic uppercase transition-colors">LOFT MANAGER</span>
        </a>
    </div>

    <!-- Nav Links -->
    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto custom-scrollbar">
        <div class="px-4 mb-4">
            <span class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">Main Matrix</span>
        </div>
        
        <x-v2-nav-link :href="route('dashboard')" icon="m19 11-7-7-7 7m14 0v8a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2v-8m14 0L12 5.41 5 11" :active="request()->routeIs('dashboard')">
            Dashboard
        </x-v2-nav-link>

        <x-v2-nav-link :href="route('pigeons.index')" icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" :active="request()->routeIs('pigeons.index')">
            Unit Manager
        </x-v2-nav-link>

        <x-v2-nav-link :href="route('training.center')" icon="M13 10V3L4 14h7v7l9-11h-7z" :active="request()->routeIs('training.center')">
            Tactical Hub
        </x-v2-nav-link>

        <x-v2-nav-link :href="route('breeding.center')" icon="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" :active="request()->routeIs('breeding.center')">
            Genetic Lab
        </x-v2-nav-link>

        <div class="px-4 mt-8 mb-4">
            <span class="text-[9px] font-black text-slate-600 uppercase tracking-[0.4em]">Network</span>
        </div>

        <x-v2-nav-link :href="route('marketplace')" icon="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" :active="request()->routeIs('marketplace')">
            Global Market
        </x-v2-nav-link>

        <x-v2-nav-link :href="route('tournaments')" icon="M13 10V3L4 14h7v7l9-11h-7z" :active="request()->routeIs('tournaments')">
            Tournaments
        </x-v2-nav-link>

        @php
            $hasStrays = Auth::user()->loft ? \App\Models\Pigeon::where('stray_at_loft_id', Auth::user()->loft->id)->exists() : false;
        @endphp
        
        <x-v2-nav-link :href="route('strays')" icon="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" :active="request()->routeIs('strays')" 
                       class="{{ $hasStrays ? 'bg-blue-500/10 border-blue-500/30 text-blue-400' : 'opacity-50 hover:opacity-100' }}">
            {{ $hasStrays ? 'Stray Detected!' : 'Stray Observation' }}
        </x-v2-nav-link>

        <x-v2-nav-link :href="route('leaderboard')" icon="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" :active="request()->routeIs('leaderboard')">
            Operator Rank
        </x-v2-nav-link>

        <div class="pt-8 mt-8 border-t border-white/5 space-y-1">
            <x-v2-nav-link :href="route('activity.log')" icon="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" :active="request()->routeIs('activity.log')">
                Archive
            </x-v2-nav-link>

            <x-v2-nav-link :href="route('faq')" icon="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" :active="request()->routeIs('faq')">
                Intelligence
            </x-v2-nav-link>

            @if(auth()->user()->is_admin)
                <x-v2-nav-link :href="route('admin')" icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" :active="request()->routeIs('admin')">
                    System Admin
                </x-v2-nav-link>
            @endif
        </div>
    </nav>

    <!-- User Section footer -->
    <div class="p-6 border-t border-white/5 bg-black/20">
        <button wire:click="logout" class="w-full flex items-center gap-4 px-6 py-4 rounded-2xl text-red-500/70 hover:bg-red-500/10 hover:text-red-500 transition-all group border border-transparent hover:border-red-500/20">
            <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            <span class="font-black text-[10px] uppercase tracking-[0.2em]">Terminate Session</span>
        </button>
    </div>
</div>
