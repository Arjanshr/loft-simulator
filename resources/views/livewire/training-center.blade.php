<div class="space-y-8 font-sans text-slate-300">
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

    <div class="parchment-panel p-6 md:p-10 rounded-[3rem] border-2 border-aviary-brass/10 shadow-2xl relative overflow-hidden galvanized-border">
        <div class="absolute top-0 right-0 p-4 md:p-8 opacity-[0.03] text-4xl md:text-8xl font-industrial font-black italic select-none pointer-events-none uppercase tracking-tighter text-aviary-brass">Exercise</div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6 border-b border-aviary-brass/10 pb-8 mb-10">
            <div>
                <h2 class="text-2xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-widest leading-none mb-2">The Exercise Yard</h2>
                <p class="text-aviary-brass/60 text-[9px] md:text-[11px] font-black uppercase tracking-[0.4em] italic">Loft Readiness & Physical Excellence Regimen</p>
            </div>
            <div class="flex items-center gap-4 bg-aviary-oak/60 p-3 pr-8 rounded-2xl border border-aviary-brass/10 shadow-inner">
                <div class="w-12 h-12 bg-aviary-brass rounded-xl flex items-center justify-center text-white shadow-[0_0_15px_rgba(184,134,11,0.3)]">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[8px] font-black text-aviary-feather/40 uppercase tracking-widest italic">Yard Status</span>
                    <span class="text-white font-industrial font-black italic uppercase">Grade {{ Auth::user()->loft->level }} Access</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12 relative z-10">
            <!-- Pigeon Selection: The Desk Ledger -->
            <div class="lg:col-span-3 space-y-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-3">
                        <div class="h-4 w-1 bg-aviary-blue"></div>
                        <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em] italic">Unit Selection</h3>
                    </div>
                    @if($pigeons->count() > 0)
                        @php
                            $allIds = $pigeons->pluck('id')->map(fn($id) => (string)$id)->toArray();
                            $allSelected = count($allIds) > 0 && count(array_diff($allIds, $selectedPigeonIds)) === 0;
                        @endphp
                        <button type="button" wire:click="toggleSelectAll" class="text-[9px] font-black uppercase tracking-wider text-aviary-brass hover:text-white transition-colors duration-300">
                            {{ $allSelected ? 'Deselect All' : 'Select All' }}
                        </button>
                    @endif
                </div>
                <div class="max-h-[40vh] lg:max-h-[65vh] overflow-y-auto space-y-3 pr-2 custom-scrollbar bg-aviary-oak/40 p-4 rounded-3xl border border-aviary-brass/10 shadow-inner">
                    @foreach($pigeons as $pigeon)
                        <label class="group flex items-center justify-between gap-4 p-4 rounded-2xl cursor-pointer transition-all duration-300 border-2 {{ in_array($pigeon->id, $selectedPigeonIds) ? 'bg-aviary-blue border-aviary-blue text-white shadow-lg' : 'bg-aviary-oak/60 border-transparent text-white hover:border-aviary-brass/30' }}">
                            <div class="flex items-center gap-4 truncate">
                                <input type="checkbox" wire:model.live="selectedPigeonIds" value="{{ $pigeon->id }}" class="hidden">
                                <div class="w-10 h-10 rounded-xl bg-black/40 flex items-center justify-center font-industrial font-black italic text-xs shrink-0 border border-white/5">
                                    {{ $pigeon->level }}
                                </div>
                                <div class="flex flex-col truncate">
                                    <span class="font-black italic uppercase text-xs truncate">{{ $pigeon->name }}</span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[8px] font-bold opacity-50 uppercase tracking-tighter">{{ $pigeon->type }}</span>
                                        <span class="w-1 h-1 rounded-full bg-aviary-brass/30"></span>
                                        <span class="text-[8px] font-black text-aviary-brass uppercase italic">LOY: {{ $pigeon->loyalty }}%</span>
                                    </div>
                                    <div class="w-16 h-1 bg-black/40 rounded-full mt-1.5 overflow-hidden">
                                        <div class="h-full bg-aviary-brass" style="width: {{ $pigeon->loyalty }}%"></div>
                                    </div>
                                </div>
                            </div>
                            @if(in_array($pigeon->id, $selectedPigeonIds))
                                <div class="shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                </div>
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Training Commands: The Tactical Board -->
            <div class="lg:col-span-9 space-y-8 md:space-y-12">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach([
                        ['type' => 'flight', 'label' => 'Flight Exercise', 'desc' => 'Endurance & Loyalty', 'cost' => '20 Energy'],
                        ['type' => 'distance', 'label' => 'Homing Drill', 'desc' => 'Speed & Navigation', 'cost' => '20 Energy'],
                        ['type' => 'grooming', 'label' => 'Feather Care', 'desc' => 'Appearance & Quality', 'cost' => number_format($totalCost) . ' 💰'],
                        ['type' => 'physical_care', 'label' => 'Health Care', 'desc' => 'Structure & Vitality', 'cost' => number_format($totalCost) . ' 💰'],
                        ['type' => 'gene_therapy', 'label' => 'Bloodline Care', 'desc' => 'Purity Enhancement', 'cost' => number_format($totalCost) . ' 💰'],
                    ] as $cmd)
                        <button wire:click="train('{{ $cmd['type'] }}')" 
                                class="group relative p-6 bg-aviary-oak/60 hover:bg-aviary-blue rounded-[2rem] border border-aviary-brass/10 transition-all duration-500 text-left overflow-hidden active:scale-95 shadow-xl galvanized-border">
                            <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 -mr-12 -mt-12 rounded-full blur-2xl group-hover:bg-black/10 transition-colors"></div>
                            <div class="relative z-10 flex flex-col h-full justify-between">
                                <div>
                                    <span class="block text-[8px] font-black text-aviary-feather/40 group-hover:text-white uppercase tracking-widest mb-2 italic">{{ $cmd['desc'] }}</span>
                                    <h4 class="text-sm md:text-base font-industrial font-black text-white group-hover:text-white uppercase italic tracking-tighter">{{ $cmd['label'] }}</h4>
                                </div>
                                <div class="mt-8 flex justify-between items-end border-t border-aviary-brass/10 group-hover:border-white/20 pt-4">
                                    <span class="text-[10px] font-mono font-bold text-aviary-brass group-hover:text-white uppercase italic">{{ $cmd['cost'] }}</span>
                                    <svg class="w-4 h-4 text-aviary-feather/40 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                                </div>
                            </div>
                        </button>
                    @endforeach

                    <!-- Restore Action -->
                    <button wire:click="restAll" 
                            class="p-6 bg-aviary-oak/40 border-2 border-dashed border-aviary-brass/20 hover:border-aviary-blue/40 hover:bg-aviary-blue/5 rounded-[2rem] transition-all duration-500 text-center flex flex-col items-center justify-center gap-3 group shadow-inner">
                        <span class="text-3xl group-hover:scale-110 transition-transform">🌿</span>
                        <div class="flex flex-col">
                            <span class="text-xs font-industrial font-black text-white uppercase italic">Full Recovery</span>
                            <span class="text-[9px] font-mono font-bold text-emerald-400 uppercase tracking-widest italic mt-1">{{ $restCost * count($selectedPigeonIds) }} 💊 TOTAL</span>
                        </div>
                    </button>
                </div>
                
                <!-- Bird Analytics: Physical Registry -->
                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="h-4 w-1 bg-aviary-brass"></div>
                        <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em] italic">Physical Analytics</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-8">
                        @forelse($selectedPigeons as $pigeon)
                            <div class="group relative bg-aviary-oak/60 rounded-[3rem] border-2 border-aviary-brass/10 transition-all duration-500 overflow-hidden shadow-2xl hover:border-aviary-blue/30 galvanized-border">
                                <div class="bg-gradient-to-r from-aviary-timber to-aviary-oak p-6 border-b border-aviary-brass/10 relative">
                                    <div class="absolute top-0 right-0 p-4 opacity-[0.03] text-4xl font-industrial font-black italic select-none pointer-events-none text-aviary-brass uppercase">{{ $pigeon->type }}</div>
                                    
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 relative z-10">
                                        <div class="flex items-center gap-6">
                                            <div class="relative w-16 h-16 shrink-0">
                                                <div class="absolute inset-0 bg-aviary-blue/10 rounded-2xl animate-pulse"></div>
                                                <div class="relative w-full h-full bg-aviary-timber rounded-2xl flex items-center justify-center text-3xl shadow-inner border border-aviary-brass/20">
                                                    🕊️
                                                </div>
                                                <div class="absolute -top-2 -left-2 bg-aviary-blue text-white font-industrial font-black text-[10px] px-2 py-0.5 rounded shadow-lg italic">
                                                    LV.{{ $pigeon->level }}
                                                </div>
                                            </div>
                                            <div>
                                                <h4 class="text-xl md:text-3xl font-industrial font-black text-white uppercase italic tracking-tighter leading-none mb-2">{{ $pigeon->name }}</h4>
                                                <div class="flex flex-wrap gap-2">
                                                    <span class="text-[9px] font-black uppercase tracking-widest border border-aviary-brass/10 px-3 py-1 rounded-full bg-black/40 text-aviary-feather/60">{{ $pigeon->rarity }} Heritage</span>
                                                    <span class="text-[9px] font-black uppercase tracking-widest {{ $pigeon->gender == 'male' ? 'bg-aviary-blue/20 text-aviary-blue border-aviary-blue/20' : 'bg-aviary-rose/20 text-aviary-rose border-aviary-rose/20' }} px-3 py-1 border rounded-full">
                                                        {{ $pigeon->gender == 'male' ? '♂ COCK' : '♀ HEN' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-left sm:text-right bg-black/40 p-4 rounded-2xl border border-aviary-brass/10 min-w-[140px] shadow-inner">
                                            <span class="text-[10px] font-black text-aviary-feather/40 uppercase tracking-widest block mb-2 italic">Condition Ring</span>
                                            <div class="flex items-center sm:justify-end gap-4">
                                                <span class="text-2xl font-mono font-bold text-white">{{ $pigeon->energy }}%</span>
                                                <div class="relative w-8 h-8">
                                                    <svg class="w-8 h-8 transform -rotate-90">
                                                        <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="3" fill="transparent" class="text-aviary-oak" />
                                                        <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="3" fill="transparent"
                                                                stroke-dasharray="88"
                                                                stroke-dashoffset="{{ 88 * (1 - ($pigeon->energy / 100)) }}"
                                                                class="{{ $pigeon->energy > 30 ? 'text-aviary-blue' : 'text-red-600' }} transition-all duration-1000" />
                                                    </svg>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="p-6 md:p-8 space-y-10">
                                    <!-- Progress Ledger -->
                                    @php
                                        $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                                        $required = $pigeon->required_stats;
                                        $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                                        $loftLevel = Auth::user()->loft->level;
                                    @endphp
                                    <div class="bg-black/30 p-6 rounded-[2rem] border border-aviary-brass/10 shadow-inner">
                                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-6">
                                            <div class="flex flex-col">
                                                <span class="text-[11px] font-black uppercase tracking-widest text-aviary-feather/40 mb-1 italic">Promotion Registry</span>
                                                <span class="text-[10px] font-mono font-bold text-aviary-brass/60 uppercase italic">{{ $totalStats }} / {{ $required }} Accumulated XP</span>
                                            </div>
                                            @if($pigeon->level < $loftLevel)
                                                <button wire:click="levelUp({{ $pigeon->id }})"
                                                    @if($totalStats < $required) disabled @endif
                                                    class="w-full sm:w-auto px-10 py-3 rounded-2xl font-black font-industrial italic uppercase text-xs transition-all shadow-xl
                                                        {{ $totalStats >= $required 
                                                            ? 'bg-aviary-brass text-white hover:bg-aviary-blue border border-white/10' 
                                                            : 'bg-aviary-timber/50 text-aviary-feather/20 cursor-not-allowed border border-white/5' }}">
                                                    Authorize Rank Up
                                                </button>
                                            @else
                                                <div class="px-6 py-3 bg-red-950/20 border border-red-500/20 rounded-2xl flex items-center gap-3">
                                                    <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-pulse"></span>
                                                    <span class="text-[9px] font-black text-red-500 uppercase italic tracking-widest">Loft Level Limit Reached</span>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="w-full h-2.5 bg-aviary-oak rounded-full overflow-hidden p-[1px] border border-white/5 shadow-inner">
                                            <div class="h-full bg-gradient-to-r from-aviary-brass to-white transition-all duration-1000 shadow-[0_0_15px_rgba(184,134,11,0.4)] rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>

                                    <!-- Technical Matrix -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 md:gap-16 font-mono">
                                        <div class="space-y-6">
                                            <h4 class="text-[11px] font-black text-aviary-feather/40 uppercase tracking-[0.3em] mb-6 flex items-center gap-3 italic">
                                                <span class="w-1.5 h-1.5 rounded-full bg-aviary-brass"></span> Performance Matrix
                                            </h4>
                                            @foreach(['speed' => 'SPD', 'endurance' => 'END', 'navigation' => 'NAV', 'temperament' => 'TMP', 'loyalty' => 'LOY', 'intelligence' => 'INT'] as $stat => $abbr)
                                                <div class="relative">
                                                    <div class="flex justify-between items-end mb-2">
                                                        <span class="text-[10px] font-bold text-aviary-feather/60 uppercase italic tracking-widest">{{ $abbr }}</span>
                                                        <div class="flex items-center gap-3">
                                                            @if(isset($statGains[$pigeon->id][$stat]))
                                                                <span class="text-[10px] font-bold text-green-500 animate-pulse">+{{ $statGains[$pigeon->id][$stat] }}</span>
                                                            @endif
                                                            <span class="text-xs font-bold {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }}">{{ $pigeon->$stat }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="flex-1 h-1 bg-aviary-oak rounded-full overflow-hidden shadow-inner">
                                                        <div class="h-full {{ isset($statGains[$pigeon->id][$stat]) ? 'bg-green-600 shadow-[0_0_10px_#16a34a]' : ($stat === 'intelligence' ? 'bg-aviary-blue' : 'bg-aviary-brass/80') }} transition-all duration-1000" style="width: {{ min(100, ($pigeon->$stat / (in_array($stat, ['loyalty', 'intelligence']) ? 100 : ($pigeon->level * 10 ?: 10))) * 100) }}%"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="space-y-6 bg-aviary-timber/30 p-8 rounded-[2.5rem] border border-aviary-brass/10 h-fit backdrop-blur-sm shadow-inner">
                                            <h4 class="text-[11px] font-black text-aviary-feather/40 uppercase tracking-[0.3em] text-center mb-8 italic">Appearance Grade</h4>
                                            <div class="grid grid-cols-2 gap-x-8 gap-y-5">
                                                @foreach(['eyes' => 'EYE', 'beak' => 'BEK', 'legs' => 'LEG', 'feather_quality' => 'FTH', 'pattern' => 'PAT', 'color' => 'CLR', 'purity' => 'BLO'] as $stat => $abbr)
                                                    <div class="flex flex-col border-b border-white/5 pb-2">
                                                        <div class="flex justify-between items-center">
                                                            <span class="text-[9px] text-aviary-feather/40 uppercase font-bold italic tracking-widest">{{ $abbr }}</span>
                                                            <div class="flex items-center gap-2">
                                                                @if(isset($statGains[$pigeon->id][$stat]))
                                                                    <span class="text-[9px] font-bold text-green-500">+{{ $statGains[$pigeon->id][$stat] }}</span>
                                                                @endif
                                                                <span class="text-xs {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }} font-bold">{{ number_format($pigeon->$stat, 1) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="mt-8 pt-6 border-t border-aviary-brass/10 text-center">
                                                <span class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-[0.2em] block mb-2 italic">Official Score</span>
                                                <span class="text-5xl font-industrial font-black text-aviary-brass trophy-gold italic">{{ $pigeon->stat_grades['beauty'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Registry Footer -->
                                <div class="px-8 py-5 bg-aviary-timber/60 flex justify-between items-center border-t border-aviary-brass/10 relative overflow-hidden">
                                    <div class="absolute inset-0 bg-gradient-to-r from-aviary-blue/5 to-transparent"></div>
                                    <div class="flex gap-8 relative z-10">
                                        <span class="text-[10px] font-bold text-aviary-feather/40 uppercase tracking-widest italic flex items-center gap-3">
                                            <span class="w-1.5 h-1.5 rounded-full bg-aviary-blue/40"></span> 
                                            Duty: {{ $pigeon->status }}
                                        </span>
                                        <span class="text-[10px] font-bold text-aviary-feather/40 uppercase tracking-widest italic flex items-center gap-3">
                                            <span class="w-1.5 h-1.5 rounded-full bg-aviary-brass/40"></span> 
                                            Age: {{ $pigeon->birth_at ? $pigeon->birth_at->diffInDays(now()) : 0 }} Days
                                        </span>
                                    </div>
                                    <span class="text-[8px] font-black text-aviary-feather/20 uppercase tracking-[0.4em] italic relative z-10">Registry Verified • Yard Ready</span>
                                </div>
                            </div>
                        @empty
                            <div class="py-32 border-2 border-dashed border-aviary-brass/10 rounded-[4rem] text-center bg-aviary-oak/10">
                                <div class="text-6xl mb-8 opacity-10">🕊️</div>
                                <p class="font-industrial font-black text-aviary-feather/20 text-xl md:text-3xl uppercase italic tracking-[0.3em]">No Units Selected for Analysis</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
