<div class="space-y-12 font-sans text-slate-300">
    <!-- Local Strays -->
    <div class="space-y-10">
        <div class="bg-[#050a0a] p-8 md:p-12 rounded-[2.5rem] md:rounded-[4rem] border-2 border-[#b8860b]/20 shadow-2xl relative overflow-hidden">
            <div class="absolute top-0 right-0 p-4 md:p-10 opacity-5 text-4xl md:text-8xl font-industrial font-black italic select-none pointer-events-none uppercase text-[#b8860b]">Watching</div>
            <h2 class="text-3xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-widest mb-4">Observation Tower</h2>
            <p class="text-[10px] md:text-xs font-black text-slate-500 uppercase tracking-[0.4em] italic">Monitoring the loft roof and nearby terrain for stray bird sightings</p>
        </div>

        @if($strays->isEmpty())
            <div class="py-32 text-center border-2 border-dashed border-[#b8860b]/10 rounded-[4rem] bg-black/20">
                <p class="text-base font-industrial font-black text-slate-700 uppercase tracking-[0.5em] italic">No unidentified birds spotted in the local sector.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 md:gap-10">
                @foreach($strays as $stray)
                    <div class="bg-indigo-950/10 border-2 border-indigo-500/20 rounded-[2.5rem] p-8 flex flex-col justify-between group hover:border-indigo-500/40 transition-all duration-500 shadow-2xl relative overflow-hidden">
                        <div class="absolute top-0 right-0 p-4 opacity-[0.03] text-6xl font-industrial font-black italic select-none pointer-events-none uppercase text-indigo-400">Visitor</div>
                        <div class="mb-10">
                            <div class="flex items-center gap-4 mb-3">
                                <span class="bg-indigo-600 text-white font-industrial font-black text-[10px] px-3 py-1 rounded-lg italic shadow-lg">LV.{{ $stray->level }}</span>
                                <h4 class="font-industrial font-black text-white uppercase tracking-widest text-lg italic truncate">{{ $stray->name }}</h4>
                            </div>
                            <div class="flex gap-2">
                                <span class="text-[8px] font-black text-indigo-300 uppercase tracking-widest border border-indigo-500/20 px-3 py-1 rounded-full bg-indigo-500/5 italic">{{ $stray->rarity }} Heritage</span>
                                <span class="text-[8px] font-black text-indigo-300 uppercase tracking-widest border border-indigo-500/20 px-3 py-1 rounded-full bg-indigo-500/5 italic">{{ $stray->type }} Strain</span>
                            </div>
                        </div>

                        <div class="flex justify-between items-center border-t border-white/5 pt-6 relative z-10">
                            @php
                                $userLoft = Auth::user()->loft;
                                $chance = 15 + ($userLoft->level - $stray->level) * 2;
                                $chance = max(5, min(95, $chance));
                            @endphp
                            <div>
                                <span class="block text-[8px] font-black text-indigo-400 uppercase tracking-widest mb-1 italic">Catch Probability</span>
                                <span class="text-2xl font-industrial font-black text-white italic">{{ $chance }}%</span>
                            </div>
                            <button wire:click="attemptCatch({{ $stray->id }})" 
                                    class="bg-indigo-600 hover:bg-white hover:text-indigo-600 text-white font-industrial font-black px-8 py-3 rounded-2xl transition shadow-xl text-[11px] uppercase tracking-widest italic active:scale-95">
                                Capture Bird
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <!-- Global Lost Feed -->
    <div class="space-y-8">
        <h3 class="text-xl font-industrial font-black text-white uppercase italic tracking-widest flex items-center gap-4">
            <span class="w-8 h-1 bg-[#b8860b] rounded-full"></span> Worldwide Lost Reports
        </h3>
        <div class="bg-[#050a0a] rounded-[3rem] border-2 border-white/5 p-8 md:p-10 shadow-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#b8860b]/5 to-transparent pointer-events-none"></div>
            <div class="space-y-6 relative z-10">
                @foreach($globalLostBirds as $bird)
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 text-xs font-bold text-slate-400 border-b border-white/5 pb-6 last:border-0 last:pb-0">
                        <div class="flex items-center gap-4">
                            <span class="text-[#b8860b] font-industrial italic tracking-widest whitespace-nowrap">{{ $bird->lost_at->format('m/d H:i') }}</span>
                            <span class="text-white uppercase tracking-widest italic">{{ $bird->name }} <span class="text-slate-600 font-normal">|</span> LV.{{ $bird->level }} {{ $bird->type }}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <span class="text-[9px] font-black text-slate-600 uppercase tracking-widest italic">Origin Loft</span>
                            <span class="text-slate-300 uppercase tracking-widest italic bg-white/5 px-3 py-1 rounded-lg border border-white/5">{{ $bird->loft->name }}</span>
                        </div>
                    </div>
                @endforeach
                @if($globalLostBirds->isEmpty())
                    <p class="text-center py-10 font-industrial font-black text-slate-800 text-xl uppercase italic tracking-widest opacity-20">No active reports from other lofts</p>
                @endif
            </div>
        </div>
    </div>
</div>
