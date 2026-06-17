<div class="max-w-2xl mx-auto p-4 md:p-6 font-sans text-slate-300 relative z-20" wire:init="startSimulation">
    <div class="parchment-panel rounded-[3rem] shadow-2xl overflow-hidden border-2 border-aviary-brass/20 relative galvanized-border">
        <!-- Header: The Flight Directive -->
        <div class="bg-aviary-brass p-8 md:p-12 text-white text-center relative overflow-hidden">
            <div class="absolute inset-0 bg-black/10"></div>
            <div class="relative z-10">
                <h2 class="text-3xl md:text-5xl font-industrial font-black italic uppercase tracking-widest leading-none mb-3 drop-shadow-lg">{{ $race->title }}</h2>
                <p class="text-white/80 font-mono font-bold uppercase text-[10px] md:text-xs tracking-[0.4em] italic">{{ $race->race_type }} Competition Sequence</p>
            </div>
            <!-- Decorative Band -->
            <div class="absolute bottom-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-white/40 to-transparent"></div>
        </div>

        <div class="p-8 md:p-16">
            @if($isSimulating)
                <!-- Simulation Phase -->
                <div class="flex flex-col items-center justify-center py-20">
                    <div class="animate-bounce mb-12 text-7xl drop-shadow-[0_0_25px_rgba(184,134,11,0.5)]">🕊️</div>
                    
                    <div class="w-full bg-aviary-oak/60 rounded-full h-2.5 max-w-sm overflow-hidden border border-aviary-brass/10 shadow-inner p-[2px]">
                        <div class="bg-gradient-to-r from-aviary-brass to-white h-full animate-progress-indefinite shadow-[0_0_15px_#b8860b] rounded-full"></div>
                    </div>
                    
                    <div class="mt-10 space-y-3 text-center">
                        <p class="text-aviary-feather/40 font-black uppercase tracking-[0.4em] italic text-[10px] animate-pulse">
                            @if($race->race_type == 'exhibition') Registry Audit: Reviewing Genetic Purity...
                            @elseif($race->race_type == 'highflyer') Monitoring Altitude & Endurance...
                            @else Tracking Velocity & Homing Precision... @endif
                        </p>
                    </div>
                </div>
            @else
                <!-- Result Phase: The Official Ledger -->
                <div class="space-y-8">
                    <div class="flex items-center gap-6 mb-10 border-b border-aviary-brass/10 pb-6">
                        <div class="w-1.5 h-6 bg-aviary-blue rounded-full shadow-[0_0_10px_#3b82f6]"></div>
                        <h3 class="text-xl md:text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Official Result Ledger</h3>
                    </div>

                    <div class="space-y-4">
                        @foreach($results as $result)
                            <div class="flex flex-col sm:flex-row items-center gap-6 p-6 rounded-[2rem] border-2 transition-all duration-500 {{ $result->pigeon_id == $pigeonId ? 'border-aviary-blue/40 bg-aviary-blue/5 shadow-xl shadow-aviary-blue/5' : 'bg-aviary-oak/40 border-aviary-brass/5' }} galvanized-border relative group">
                                <!-- Rank Marker -->
                                <div class="w-12 h-12 flex items-center justify-center rounded-xl font-industrial font-black text-2xl {{ $result->position <= 3 ? 'bg-aviary-brass text-white shadow-lg trophy-gold' : 'bg-black/40 text-aviary-feather/20' }} italic">
                                    {{ $result->position }}
                                </div>

                                <!-- Participant Info -->
                                <div class="flex-1 text-center sm:text-left">
                                    <span class="font-industrial font-black text-white uppercase tracking-widest italic block text-lg md:text-xl mb-1">{{ $result->pigeon->name ?? 'Unregistered Participant' }}</span>
                                    <div class="flex items-center gap-3 mt-1">
                                    <span class="text-[9px] font-mono font-bold text-aviary-feather/40 uppercase tracking-widest italic">
                                        @if($race->race_type == 'exhibition') Aesthetics Grade: {{ number_format($result->pigeon->beauty, 2) }}
                                        @else Flight Time: {{ gmdate("H:i:s", $result->finish_time_seconds) }} @endif
                                    </span>
                                    <span class="text-[8px] font-black {{ $result->pigeon->gender == 'male' ? 'text-aviary-blue' : 'text-aviary-rose' }} italic uppercase tracking-tighter">
                                        {{ $result->pigeon->gender == 'male' ? '♂ COCK' : '♀ HEN' }}
                                    </span>
                                </div>
                                </div>

                                <!-- Payout & Badge -->
                                <div class="flex items-center gap-6">
                                    @if($result->payout > 0)
                                        <div class="text-aviary-brass font-industrial font-black italic text-xl md:text-2xl trophy-gold drop-shadow-sm">
                                            +{{ number_format($result->payout) }}💰
                                        </div>
                                    @endif
                                    
                                    @if($result->pigeon_id == $pigeonId)
                                        <div class="bg-aviary-blue text-white text-[9px] px-4 py-1.5 rounded-full font-black uppercase italic tracking-widest shadow-lg border border-white/20">Your Unit</div>
                                    @endif
                                </div>
                                
                                @if($result->pigeon_id == $pigeonId)
                                    <div class="absolute inset-0 bg-gradient-to-r from-aviary-blue/5 to-transparent pointer-events-none rounded-[2rem]"></div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                    <!-- Actions -->
                    <div class="mt-16 pt-10 border-t border-aviary-brass/10 flex justify-center">
                        <a href="{{ route('dashboard') }}" class="group bg-white hover:bg-aviary-blue text-black hover:text-white px-16 py-5 rounded-[2rem] font-industrial font-black transition-all shadow-2xl uppercase italic tracking-[0.2em] text-sm border-2 border-black/5">
                            <span class="group-hover:scale-105 transition-transform block">Return to Registry</span>
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
            animation: progress-indefinite 3s ease-in-out infinite;
        }
    </style>
</div>
