<div class="text-slate-300 font-sans" x-data="{}" x-on:pigeon-leveled-up.window="alert('Congratulations! ' + $event.detail.name + ' reached a new rank!')" wire:poll.60s>
    <!-- Notifications -->
    <div class="fixed top-20 right-4 z-50 flex flex-col gap-2">
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
                 class="bg-aviary-blue text-white px-6 py-3 rounded-xl shadow-2xl font-industrial italic border-2 border-white/20 animate-bounce">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
                 class="bg-red-800 text-white px-6 py-3 rounded-xl shadow-2xl font-industrial border-2 border-white/20 italic">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 xl:grid-cols-2 gap-8">
        @foreach($pigeons as $pigeon)
            <div class="group relative bg-aviary-oak/80 rounded-[2.5rem] border-2 border-aviary-brass/10 hover:border-aviary-blue/30 transition-all duration-500 overflow-hidden shadow-2xl galvanized-border">
                <!-- Registry Header -->
                <div class="bg-gradient-to-r from-aviary-timber to-aviary-oak p-6 border-b border-aviary-brass/10 relative">
                    <div class="absolute top-0 right-0 p-4 opacity-[0.05] text-4xl font-industrial font-black italic select-none pointer-events-none text-aviary-brass uppercase">{{ $pigeon->type }}</div>
                    <div class="flex flex-col sm:flex-row justify-between items-start gap-4">
                        <div class="flex-1 w-full">
                            <div class="flex items-center gap-3 mb-4">
                                <span class="bg-aviary-blue text-white font-industrial font-black text-xs px-2 py-0.5 rounded italic shadow-lg">LV.{{ $pigeon->level }}</span>
                                <input type="text" wire:model.lazy="newName.{{ $pigeon->id }}" 
                                       wire:keydown.enter="updateName({{ $pigeon->id }})"
                                       placeholder="{{ $pigeon->name }}" 
                                       class="bg-transparent border-none p-0 text-2xl font-industrial font-black text-white focus:ring-0 w-full placeholder-white/20 italic uppercase tracking-tight">
                            </div>
                            <x-pigeon.registry-meta :pigeon="$pigeon" size="sm" class="mb-3" />
                            <div class="flex flex-wrap gap-2">
                                <span class="text-[9px] font-black uppercase tracking-widest {{ $pigeon->gender == 'male' ? 'bg-aviary-blue/20 text-aviary-blue border-aviary-blue/20' : 'bg-aviary-rose/20 text-aviary-rose border-aviary-rose/20' }} px-3 py-1 border rounded-full">
                                    {{ $pigeon->gender == 'male' ? '♂ COCK' : '♀ HEN' }}
                                </span>
                                <!-- Type Label -->
                                <span class="text-[9px] font-black uppercase tracking-widest bg-white/10 text-white px-3 py-1 rounded-full border border-white/20">
                                    {{ strtoupper($pigeon->type) }}
                                </span>
                                @if($pigeon->income_per_minute > 0)
                                    <span class="text-[9px] font-black uppercase tracking-widest bg-green-900/20 text-green-400 border border-green-500/20 px-3 py-1 rounded-full">+{{ $pigeon->income_per_minute }} 💰/MIN</span>
                                @endif
                                @if($pigeon->vitamin_income_per_minute > 0)
                                    <span class="text-[9px] font-black uppercase tracking-widest bg-emerald-900/20 text-emerald-400 border border-emerald-500/20 px-3 py-1 rounded-full">+{{ $pigeon->vitamin_income_per_minute }} 💊/MIN</span>
                                @endif
                                @if($pigeon->token_income_per_minute > 0)
                                    <span class="text-[9px] font-black uppercase tracking-widest bg-purple-900/20 text-purple-400 border border-purple-500/20 px-3 py-1 rounded-full">+{{ $pigeon->token_income_per_minute }} 🎟️/MIN</span>
                                @endif
                            </div>
                        </div>

                        <!-- Condition Ring (Energy) -->
                        <div class="flex flex-row sm:flex-col items-center sm:items-end gap-4 bg-black/20 p-4 rounded-2xl border border-aviary-brass/10">
                            <div class="text-right">
                                <span class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest block italic leading-none mb-1">Condition</span>
                                <span class="text-xs font-mono font-bold text-white">{{ $pigeon->energy }}%</span>
                            </div>
                            <div class="relative w-12 h-12 flex items-center justify-center">
                                <svg class="w-12 h-12 transform -rotate-90">
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent" class="text-aviary-oak" />
                                    <circle cx="24" cy="24" r="20" stroke="currentColor" stroke-width="4" fill="transparent"
                                            stroke-dasharray="125.6"
                                            stroke-dashoffset="{{ 125.6 * (1 - ($pigeon->energy / 100)) }}"
                                            class="{{ $pigeon->energy > 30 ? 'text-aviary-blue' : 'text-red-600' }} transition-all duration-1000" />
                                </svg>
                                <span class="absolute text-[10px] font-black text-white italic font-industrial">{{ $pigeon->energy }}%</span>
                            </div>
                            @if($pigeon->energy < 100)
                                <button wire:click="rest({{ $pigeon->id }})" class="text-[9px] font-black bg-emerald-600 hover:bg-aviary-blue text-white px-3 py-1.5 rounded-lg transition uppercase italic border border-white/10 shadow-lg">
                                    Rest (50💊)
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="p-6 md:p-8 space-y-8">
                    <!-- Homing Instinct & Learning Rate -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div class="bg-black/20 p-5 rounded-2xl border border-aviary-brass/10">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-aviary-feather/40 mb-3">
                                <span class="italic">Loyalty: {{ $pigeon->loyalty }}%</span>
                                <span class="text-aviary-brass italic">Homing</span>
                            </div>
                            <div class="w-full h-2 bg-aviary-oak rounded-full overflow-hidden">
                                <div class="h-full bg-aviary-brass transition-all duration-700 shadow-[0_0_10px_#b8860b]" style="width: {{ $pigeon->loyalty }}%"></div>
                            </div>
                        </div>
                        <div class="bg-black/20 p-5 rounded-2xl border border-aviary-brass/10">
                            <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-aviary-feather/40 mb-3">
                                <span class="italic">Intelligence: {{ $pigeon->intelligence }}</span>
                                <span class="text-aviary-blue italic">Insight</span>
                            </div>
                            <div class="w-full h-2 bg-aviary-oak rounded-full overflow-hidden">
                                <div class="h-full bg-aviary-blue transition-all duration-700 shadow-[0_0_10px_#3b82f6]" style="width: {{ $pigeon->intelligence }}%"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Training Ledger -->
                    @php
                        $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                        $required = $pigeon->required_stats;
                        $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                        $loftLevel = Auth::user()->loft->level;
                        $canRankUp = $totalStats >= $required && $pigeon->level < 100 && $pigeon->level < $loftLevel;
                        $atLoftCap = $pigeon->level >= $loftLevel;
                    @endphp
                    <div class="parchment-panel p-6 rounded-2xl border border-aviary-brass/10">
                        <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">
                            <div class="flex-1 w-full">
                                <div class="flex justify-between text-[10px] font-black uppercase tracking-widest text-aviary-feather/40 mb-3 italic">
                                    <span>Training Progress</span>
                                    <span>{{ $totalStats }} / {{ $required }} pts</span>
                                </div>
                                <div class="w-full h-3 bg-aviary-oak rounded-full overflow-hidden border border-white/5">
                                    <div class="h-full bg-aviary-brass transition-all duration-700" style="width: {{ $progress }}%"></div>
                                </div>
                            </div>
                            @if($totalStats >= $required)
                                @if($canRankUp)
                                    <button wire:click="levelUp({{ $pigeon->id }})" 
                                            class="w-full md:w-auto bg-aviary-blue text-white font-industrial font-black text-xs px-6 py-3 rounded-xl hover:bg-aviary-brass transition shadow-xl uppercase italic border border-white/20">
                                        Promote
                                    </button>
                                @elseif($atLoftCap)
                                    <div class="px-4 py-2 bg-aviary-brass/10 border border-aviary-brass/20 rounded-lg">
                                        <span class="text-[8px] font-black text-aviary-brass uppercase tracking-tighter italic">Loft Level Cap</span>
                                    </div>
                                @endif
                            @endif
                        </div>

                        <!-- Stats Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 font-mono">
                            <div class="space-y-4">
                                <h4 class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest mb-4 italic">Performance Log</h4>
                                @foreach(['speed' => 'SPD', 'endurance' => 'END', 'navigation' => 'NAV', 'temperament' => 'TMP'] as $stat => $abbr)
                                    <div class="relative">
                                        <div class="flex justify-between items-end mb-1">
                                            <span class="text-[9px] text-aviary-feather/60 uppercase italic">{{ $abbr }}</span>
                                            <span class="text-xs font-bold text-white">{{ $pigeon->$stat }} <span class="text-aviary-brass text-[10px] ml-1">[{{ $pigeon->stat_grades[$stat] }}]</span></span>
                                        </div>
                                        <div class="h-1 bg-aviary-oak rounded-full overflow-hidden">
                                            <div class="h-full bg-aviary-brass transition-all duration-1000" style="width: {{ ($pigeon->$stat / ($pigeon->level * $pigeon->stat_limit_multiplier ?: 10)) * 100 }}%"></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bg-black/30 p-4 rounded-xl border border-aviary-brass/10">
                                <h4 class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest mb-4 text-center italic">Appearance Grade: <span class="text-aviary-brass">{{ $pigeon->stat_grades['beauty'] }}</span></h4>
                                <div class="grid grid-cols-2 gap-x-4 gap-y-3">
                                    @foreach(['eyes' => 'EYE', 'beak' => 'BEK', 'legs' => 'LEG', 'feather_quality' => 'FTH', 'pattern' => 'PAT', 'color' => 'CLR', 'purity' => 'BLO'] as $stat => $abbr)
                                        <div class="flex justify-between items-center border-b border-aviary-brass/5 pb-1">
                                            <span class="text-[8px] text-aviary-feather/40 uppercase font-bold italic">{{ $abbr }}</span>
                                            <span class="text-[10px] text-white font-bold">{{ number_format($pigeon->$stat, 1) }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Registry Footer -->
                <div class="px-8 py-4 bg-aviary-timber/60 flex justify-between items-center border-t border-aviary-brass/10">
                    <span class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-[0.2em] italic">Status: {{ strtoupper($pigeon->status) }}</span>
                    <span class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-[0.2em] italic">Hatch Date: {{ $pigeon->created_at->format('M d, Y') }}</span>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-12">
        {{ $pigeons->links() }}
    </div>
</div>
