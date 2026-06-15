<div class="mb-12">
    @if($strays->isNotEmpty())
        <div class="flex items-center gap-4 mb-6">
            <div class="w-3 h-10 bg-blue-500 rounded-full shadow-[0_0_15px_rgba(59,130,246,0.4)]"></div>
            <div>
                <h3 class="text-xl font-industrial font-black text-white uppercase italic tracking-widest leading-none">Stray Detection</h3>
                <p class="text-[9px] font-black text-blue-400 uppercase tracking-[0.3em] mt-1">Unknown biological signals detected on loft perimeter</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @foreach($strays as $stray)
                <div class="bg-blue-950/20 border-2 border-blue-500/30 rounded-3xl p-6 flex justify-between items-center relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4 opacity-5 text-4xl font-industrial font-black italic select-none pointer-events-none uppercase">Stray</div>
                    
                    <div class="relative z-10">
                        <div class="flex items-center gap-3 mb-2">
                            <span class="bg-blue-500 text-white font-industrial font-black text-[10px] px-2 py-0.5 rounded italic shadow-lg">LV.{{ $stray->level }}</span>
                            <h4 class="font-industrial font-black text-white uppercase tracking-wider text-sm">{{ $stray->name }}</h4>
                        </div>
                        <div class="flex gap-2">
                            <span class="text-[8px] font-black text-blue-300 uppercase tracking-widest border border-blue-500/20 px-2 py-0.5 rounded-full">{{ $stray->rarity }}</span>
                            <span class="text-[8px] font-black text-blue-300 uppercase tracking-widest border border-blue-500/20 px-2 py-0.5 rounded-full">{{ $stray->type }}</span>
                        </div>
                    </div>

                    <div class="relative z-10">
                        @php
                            $userLoft = Auth::user()->loft;
                            $chance = 15 + ($userLoft->level - $stray->level) * 2;
                            $chance = max(5, min(95, $chance));
                        @endphp
                        <div class="text-right mb-3">
                            <span class="block text-[8px] font-black text-blue-400 uppercase tracking-widest">Capture Probability</span>
                            <span class="text-lg font-industrial font-black text-white">{{ $chance }}%</span>
                        </div>
                        <button wire:click="attemptCatch({{ $stray->id }})" 
                                class="bg-blue-500 hover:bg-blue-400 text-white font-industrial font-black px-6 py-2 rounded-xl transition shadow-lg shadow-blue-500/20 text-[10px] uppercase tracking-widest italic active:scale-95">
                            Attempt Capture
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
