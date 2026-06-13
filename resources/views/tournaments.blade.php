<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-yellow-500 uppercase tracking-widest">
            {{ __('Tournaments') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-black min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-slate-900 p-8 rounded-2xl shadow-xl border border-slate-700">
                <h2 class="text-2xl font-black text-white mb-6">Available Tournaments</h2>
                <livewire:race-lobby />
            </div>
            
            <div class="mt-8">
                <livewire:race-history-display />
            </div>
        </div>
    </div>
</x-app-layout>
