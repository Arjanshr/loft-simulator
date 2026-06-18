<div class="mb-12 font-sans relative z-20">
    @if($strays->isNotEmpty())
        <div class="flex items-center gap-6 mb-10">
            <div class="w-12 h-1.5 bg-aviary-blue rounded-full shadow-[0_0_15px_#3b82f6]"></div>
            <div>
                <h3 class="text-2xl md:text-3xl font-industrial font-black text-white uppercase italic tracking-widest leading-none mb-2">Observation Post</h3>
                <p class="text-aviary-blue text-[9px] md:text-[11px] font-black uppercase tracking-[0.4em] italic">Unidentified specimens detected within Loft territory</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            @foreach($strays as $stray)
                <div class="parchment-panel border-2 border-aviary-blue/20 rounded-[3rem] p-6 md:p-10 flex flex-col sm:flex-row justify-between items-center relative overflow-hidden group shadow-2xl galvanized-border">
                    <div class="absolute top-0 right-0 p-6 opacity-[0.03] text-6xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-blue">Stray</div>
                        <div class="absolute inset-0 bg-gradient-to-br from-aviary-blue/5 to-transparent pointer-events-none"></div>
                        
                        <div class="relative z-10 text-center sm:text-left mb-6 sm:mb-0">
                            <div class="flex items-center justify-center sm:justify-start gap-4 mb-4">
                                <span class="bg-aviary-blue text-white font-industrial font-black text-xs px-3 py-1 rounded-xl italic shadow-lg">LV.{{ $stray->level }}</span>
                                <h4 class="font-industrial font-black text-xl md:text-2xl text-white uppercase tracking-widest italic">{{ $stray->name }}</h4>
                            </div>
                            <div class="flex flex-wrap justify-center sm:justify-start gap-3">
                                <span class="text-[9px] font-black {{ $stray->gender == 'male' ? 'text-aviary-blue border-aviary-blue/20 bg-aviary-blue/5' : 'text-aviary-rose border-aviary-rose/20 bg-aviary-rose/5' }} uppercase tracking-widest border px-4 py-1.5 rounded-full italic font-mono">{{ $stray->gender == 'male' ? '♂ COCK' : '♀ HEN' }}</span>
                            </div>
                            <x-pigeon.registry-meta :pigeon="$stray" size="sm" class="mt-3 justify-center sm:justify-start" />
                        </div>

                    <div class="relative z-10 text-center sm:text-right bg-black/40 p-6 rounded-[2rem] border border-aviary-blue/10 min-w-[160px] shadow-inner">
                        @php
                            $userLoft = Auth::user()->loft;
                            $chance = 15 + ($userLoft->level - $stray->level) * 2;
                            $chance = max(5, min(95, $chance));
                        @endphp
                        <div class="mb-5">
                            <span class="block text-[9px] font-black text-aviary-blue uppercase tracking-widest italic mb-1">Catch Probability</span>
                            <span class="text-3xl font-mono font-bold text-white italic">{{ $chance }}%</span>
                        </div>
                        <button wire:click="attemptCatch({{ $stray->id }})" 
                                class="w-full bg-aviary-blue hover:bg-white hover:text-aviary-blue text-white font-industrial font-black px-6 py-4 rounded-[1.5rem] transition-all shadow-xl text-[10px] uppercase tracking-[0.2em] italic active:scale-95 border border-white/10 group/btn">
                            <span class="group-hover/btn:scale-105 transition-transform block">Authorize Capture</span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
