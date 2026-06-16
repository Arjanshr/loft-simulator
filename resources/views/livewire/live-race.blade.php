<div class="max-w-2xl mx-auto p-6 font-sans text-slate-300" wire:init="startSimulation">
    <div class="bg-[#050a0a] rounded-[2.5rem] shadow-2xl overflow-hidden border-2 border-[#b8860b]/20 relative">
        <div class="bg-[#b8860b] p-10 text-white text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-4xl font-industrial font-black italic uppercase tracking-widest leading-none">{{ $race->title }}</h2>
                <p class="text-white/70 mt-3 font-bold uppercase text-xs tracking-[0.3em] italic">{{ $race->race_type }} Competition</p>
            </div>
        </div>

        <div class="p-8 md:p-12">
            @if($isSimulating)
                <div class="flex flex-col items-center justify-center py-16">
                    <div class="animate-bounce mb-8 text-6xl drop-shadow-[0_0_20px_rgba(184,134,11,0.4)]">🕊️</div>
                    <div class="w-full bg-black/40 rounded-full h-1.5 max-w-xs overflow-hidden border border-white/5 shadow-inner">
                        <div class="bg-[#b8860b] h-full animate-progress-indefinite shadow-[0_0_10px_#b8860b]"></div>
                    </div>
                    <p class="mt-8 text-slate-500 font-black uppercase tracking-[0.3em] italic text-xs animate-pulse">
                        @if($race->race_type == 'exhibition') Reviewing Bloodlines...
                        @elseif($race->race_type == 'highflyer') Measuring Endurance...
                        @else Calculating Velocity... @endif
                    </p>
                </div>
            @else
                <div class="space-y-6">
                    <h3 class="text-xl font-industrial font-black mb-8 flex items-center gap-4 text-white uppercase italic tracking-widest border-b border-white/5 pb-4">
                        <span class="w-8 h-1 bg-[#b8860b] rounded-full"></span> Official Ledger
                    </h3>

                    @foreach($results as $result)
                        <div class="flex items-center gap-6 p-5 rounded-2xl border-2 transition-all duration-500 {{ $result->pigeon_id == $pigeonId ? 'border-[#b8860b]/40 bg-[#b8860b]/10 shadow-lg' : 'bg-black/40 border-white/5' }}">
                            <div class="w-10 h-10 flex items-center justify-center rounded-xl font-industrial font-black text-lg {{ $result->position <= 3 ? 'bg-[#b8860b] text-white shadow-lg' : 'bg-slate-800 text-slate-500' }} italic">
                                {{ $result->position }}
                            </div>
                            <div class="flex-1">
                                <span class="font-bold text-white uppercase tracking-widest italic block text-sm md:text-base">{{ $listing->pigeon->name ?? 'Participant' }}</span>
                                <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest mt-1 block italic">
                                    @if($race->race_type == 'exhibition') Appearance Score: {{ number_format($result->pigeon->beauty, 2) }}
                                    @else Time: {{ gmdate("H:i:s", $result->finish_time_seconds) }} @endif
                                </span>
                            </div>
                            @if($result->payout > 0)
                                <div class="text-green-500 font-industrial font-black italic text-lg md:text-xl">
                                    +{{ number_format($result->payout) }}💰
                                </div>
                            @endif
                            @if($result->pigeon_id == $pigeonId)
                                <div class="bg-white text-black text-[9px] px-3 py-1 rounded-lg font-black uppercase italic tracking-tighter shadow-lg">YOUR BIRD</div>
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-12 pt-8 border-t border-white/5 flex justify-center">
                        <a href="{{ route('dashboard') }}" class="bg-white hover:bg-[#b8860b] text-black hover:text-white px-12 py-4 rounded-2xl font-industrial font-black transition-all shadow-2xl uppercase italic tracking-widest text-sm">
                            Return to Loft
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes progress-indefinite {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(100%); }
        }
        .animate-progress-indefinite {
            width: 100%;
            animation: progress-indefinite 2.5s ease-in-out infinite;
        }
    </style>
</div>
