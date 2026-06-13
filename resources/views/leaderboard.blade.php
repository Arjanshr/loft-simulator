<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-yellow-500 uppercase tracking-widest">
            {{ __('Leaderboards') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <livewire:leaderboard />
        </div>
    </div>
</x-app-layout>