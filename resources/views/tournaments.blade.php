<x-app-layout>
    <x-slot name="header">
        {{ __('Battle Arena') }}
    </x-slot>

    <div class="space-y-12">
        <div class="bg-slate-950 p-10 rounded-[3rem] border-2 border-slate-800 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5 text-8xl font-industrial font-black italic select-none pointer-events-none uppercase">Combat</div>
            
            <div class="relative z-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-1 bg-yellow-500 rounded-full"></div>
                    <h2 class="text-3xl font-industrial font-black text-white uppercase italic tracking-widest">Available Operations</h2>
                </div>
                <livewire:race-lobby />
            </div>
        </div>
        
        <div class="bg-slate-950 p-10 rounded-[3rem] border-2 border-slate-800 shadow-2xl">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-12 h-1 bg-yellow-500 rounded-full"></div>
                <h2 class="text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Deployment History</h2>
            </div>
            <livewire:race-history-display />
        </div>
    </div>
</x-app-layout>
