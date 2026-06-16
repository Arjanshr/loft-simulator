<div class="mb-12 font-sans">
    @if($strays->isNotEmpty())
        <div class="flex items-center gap-6 mb-8">
            <div class="w-3 h-12 bg-indigo-600 rounded-full shadow-[0_0_15px_rgba(79,70,229,0.3)]"></div>
            <div>
                <h3 class="text-2xl font-industrial font-black text-white uppercase italic tracking-widest leading-none">Bird Watching</h3>
                <p class="text-[9px] font-black text-indigo-400 uppercase tracking-[0.3em] mt-2 italic">Unidentified birds spotted near the loft grounds</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($strays as $stray)
                <div class="bg-indigo-950/10 border-2 border-indigo-500/20 rounded-[2rem] p-6 md:p-8 flex justify-between items-center relative overflow-hidden group shadow-xl">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-4xl font-industrial font-black italic select-none pointer-events-none uppercase text-indigo-400">Visitor</div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-4 mb-3">
                            <span class="bg-indigo-600 text-white font-industrial font-black text-[10px] px-3 py-1 rounded-lg italic shadow-lg">LV.{{ $stray->level }}</span>
                            <h4 class="font-industrial font-black text-white uppercase tracking-widest text-base italic">{{ $stray->name }}</h4>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-[8px] font-black text-indigo-300 uppercase tracking-widest border border-indigo-500/20 px-3 py-1 rounded-full bg-indigo-500/5 italic">{{ $stray->rarity }} Heritage</span>
                            <span class="text-[8px] font-black text-indigo-300 uppercase tracking-widest border border-indigo-500/20 px-3 py-1 rounded-full bg-indigo-500/5 italic">{{ $stray->type }} Strain</span>
                        </div>
                    </div>

                    <div class="relative z-10 text-right">
                        @php
                            $userLoft = Auth::user()->loft;
                            $chance = 15 + ($userLoft->level - $stray->level) * 2;
                            $chance = max(5, min(95, $chance));
                        @endphp
                        <div class="mb-4">
                            <span class="block text-[8px] font-black text-indigo-400 uppercase tracking-widest italic">Catch Success</span>
                            <span class="text-2xl font-industrial font-black text-white italic">{{ $chance }}%</span>
                        </div>
                        <button wire:click="attemptCatch({{ $stray->id }})" 
                                class="bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white font-industrial font-black px-8 py-3 rounded-2xl transition shadow-xl text-[10px] uppercase tracking-[0.2em] italic active:scale-95">
                            Attempt Capture
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
