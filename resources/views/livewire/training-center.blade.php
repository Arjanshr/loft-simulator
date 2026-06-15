<div class="space-y-6 md:space-y-10 p-4 md:p-10 bg-slate-950 rounded-[2.5rem] md:rounded-[4rem] border-2 border-slate-900 shadow-2xl relative overflow-hidden">
    <!-- Decorative tactical elements -->
    <div class="absolute top-0 right-0 p-10 opacity-5 select-none pointer-events-none font-industrial text-7xl md:text-9xl italic font-black uppercase tracking-tighter">Combat Training</div>
    <div class="absolute -top-24 -left-24 w-64 h-64 bg-yellow-500/10 blur-[100px] rounded-full"></div>
    
    <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4 border-b border-white/5 pb-8 mb-4">
        <div>
            <h2 class="text-2xl md:text-5xl font-industrial font-black text-white uppercase italic tracking-widest leading-none mb-2">Tactical Hub</h2>
            <p class="text-yellow-500/50 text-[10px] font-black uppercase tracking-[0.5em] italic">Combat Readiness & Aesthetic Enhancement Protocol</p>
        </div>
        <div class="flex items-center gap-4 bg-black/40 p-2 pr-6 rounded-2xl border border-white/5">
            <div class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center text-black shadow-[0_0_15px_rgba(234,179,8,0.4)]">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <div class="flex flex-col">
                <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest">Loft Status</span>
                <span class="text-white font-industrial font-black italic">LV.{{ Auth::user()->loft->level }} OPERATIONAL</span>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="msg-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-green-600 text-white px-6 py-4 rounded-2xl shadow-2xl font-black font-industrial italic border-2 border-white/20 animate-slide-in">
            <span class="mr-3">✓</span> {{ session('message') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" 
             wire:key="err-{{ microtime() }}"
             class="fixed top-20 right-4 z-50 bg-red-600 text-white px-6 py-4 rounded-2xl shadow-2xl font-black font-industrial italic border-2 border-white/20 animate-shake">
            <span class="mr-3">⚠</span> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 md:gap-12">
        <!-- Pigeon Selection - Tactical Grid -->
        <div class="lg:col-span-3 space-y-6">
            <div class="flex items-center gap-3 mb-2">
                <div class="h-4 w-1 bg-yellow-500"></div>
                <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Select Personnel</h3>
            </div>
            <div class="max-h-[40vh] lg:max-h-[65vh] overflow-y-auto space-y-3 pr-2 custom-scrollbar bg-black/30 p-4 rounded-3xl border border-white/5">
                @foreach($pigeons as $pigeon)
                    <label class="group flex items-center justify-between gap-4 p-4 rounded-2xl cursor-pointer transition-all duration-300 border-2 {{ in_array($pigeon->id, $selectedPigeonIds) ? 'bg-yellow-500 border-yellow-400 text-black shadow-[0_0_20px_rgba(234,179,8,0.2)]' : 'bg-slate-900 border-transparent text-white hover:border-white/10' }}">
                        <div class="flex items-center gap-4 truncate">
                            <input type="checkbox" wire:model.live="selectedPigeonIds" value="{{ $pigeon->id }}" class="hidden">
                            <div class="w-10 h-10 rounded-xl bg-black/20 flex items-center justify-center font-industrial font-black italic text-xs shrink-0">
                                {{ $pigeon->level }}
                            </div>
                            <div class="flex flex-col truncate">
                                <span class="font-black italic uppercase text-xs truncate">{{ $pigeon->name }}</span>
                                <span class="text-[8px] font-bold opacity-50 uppercase tracking-tighter">{{ $pigeon->type }} Class</span>
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

        <!-- Training Commands -->
        <div class="lg:col-span-9 space-y-8 md:space-y-12">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                <!-- Training Cards -->
                @foreach([
                    ['type' => 'flight', 'label' => 'Flight Training', 'desc' => 'Endurance & Loyalty', 'cost' => '20 Energy'],
                    ['type' => 'distance', 'label' => 'Distance Protocol', 'desc' => 'Speed & Loyalty', 'cost' => '20 Energy'],
                    ['type' => 'grooming', 'label' => 'Aesthetic Refine', 'desc' => 'Feathers & Color', 'cost' => number_format($totalCost) . ' 💰'],
                    ['type' => 'physical_care', 'label' => 'Structural Care', 'desc' => 'Beak, Legs, Eyes', 'cost' => number_format($totalCost) . ' 💰'],
                    ['type' => 'gene_therapy', 'label' => 'Genetic Purity', 'desc' => 'Purity Enhancement', 'cost' => number_format($totalCost) . ' 💰'],
                ] as $cmd)
                    <button wire:click="train('{{ $cmd['type'] }}')" 
                            class="group relative p-6 bg-slate-900 hover:bg-yellow-500 rounded-3xl border border-white/5 transition-all duration-500 text-left overflow-hidden active:scale-95 shadow-xl">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/5 -mr-12 -mt-12 rounded-full blur-2xl group-hover:bg-black/10"></div>
                        <div class="relative z-10 flex flex-col h-full justify-between">
                            <div>
                                <span class="block text-[8px] font-black text-slate-500 group-hover:text-black uppercase tracking-widest mb-1">{{ $cmd['desc'] }}</span>
                                <h4 class="text-sm md:text-base font-industrial font-black text-white group-hover:text-black uppercase italic tracking-tighter">{{ $cmd['label'] }}</h4>
                            </div>
                            <div class="mt-6 flex justify-between items-end border-t border-white/5 group-hover:border-black/10 pt-4">
                                <span class="text-[10px] font-black text-yellow-500 group-hover:text-black uppercase italic">{{ $cmd['cost'] }}</span>
                                <svg class="w-4 h-4 text-slate-600 group-hover:text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </div>
                        </div>
                    </button>
                @endforeach

                <!-- Restore Action -->
                <button wire:click="restAll" 
                        class="p-6 bg-slate-900 border-2 border-dashed border-yellow-500/30 hover:bg-yellow-500/10 rounded-3xl transition-all duration-500 text-center flex flex-col items-center justify-center gap-2 group">
                    <span class="text-2xl group-hover:scale-110 transition-transform">⚡</span>
                    <div class="flex flex-col">
                        <span class="text-xs font-industrial font-black text-white uppercase italic">Restore Energy</span>
                        <span class="text-[9px] font-black text-yellow-500 uppercase tracking-widest">{{ $restCost * count($selectedPigeonIds) }} 💰 TOTAL</span>
                    </div>
                </button>
            </div>
            
            <!-- Personnel Files (Selected Pigeons) -->
            <div class="space-y-6 md:space-y-8">
                <div class="flex items-center gap-3">
                    <div class="h-4 w-1 bg-yellow-500"></div>
                    <h3 class="text-[10px] font-black text-white uppercase tracking-[0.2em]">Personnel Analytics</h3>
                </div>

                <div class="grid grid-cols-1 gap-6 md:gap-8">
                    @forelse($selectedPigeons as $pigeon)
                        <div class="group relative bg-slate-900/50 rounded-[2.5rem] border-2 border-white/5 transition-all duration-500 overflow-hidden shadow-2xl hover:border-yellow-500/20">
                            <div class="bg-gradient-to-r from-slate-900 to-black p-6 border-b border-white/5">
                                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                    <div class="flex items-center gap-5">
                                        <div class="relative w-16 h-16 shrink-0">
                                            <div class="absolute inset-0 bg-yellow-500/20 rounded-2xl animate-pulse"></div>
                                            <div class="relative w-full h-full bg-slate-800 rounded-2xl flex items-center justify-center text-3xl shadow-inner border border-white/10">
                                                🕊️
                                            </div>
                                            <div class="absolute -top-2 -left-2 bg-yellow-500 text-black font-industrial font-black text-[10px] px-2 py-0.5 rounded shadow-lg italic">
                                                LV.{{ $pigeon->level }}
                                            </div>
                                        </div>
                                        <div>
                                            <h4 class="text-xl md:text-3xl font-industrial font-black text-white uppercase italic tracking-tighter leading-none mb-1">{{ $pigeon->name }}</h4>
                                            <div class="flex flex-wrap gap-2">
                                                <span class="text-[8px] font-black text-slate-500 uppercase tracking-widest border border-white/5 px-2 py-0.5 rounded-full">{{ $pigeon->type }} Unit</span>
                                                <span class="text-[8px] font-black text-yellow-500/70 uppercase tracking-widest border border-yellow-500/10 px-2 py-0.5 rounded-full">{{ $pigeon->rarity }} Grade</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-left sm:text-right bg-black/40 p-4 rounded-2xl border border-white/5 min-w-[120px]">
                                        <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest block mb-1">Combat Vitality</span>
                                        <div class="flex items-center sm:justify-end gap-3">
                                            <span class="text-2xl font-industrial font-black text-white italic">{{ $pigeon->energy }}%</span>
                                            <div class="w-12 h-1.5 bg-slate-800 rounded-full overflow-hidden">
                                                <div class="h-full bg-yellow-500" style="width: {{ $pigeon->energy }}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="p-6 md:p-8">
                                @php
                                    $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                                    $required = $pigeon->level * 30;
                                    $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                                @endphp
                                <div class="bg-black/40 p-5 rounded-3xl border border-white/5 mb-8">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-5 gap-4">
                                        <div class="flex flex-col">
                                            <span class="text-[10px] font-black uppercase tracking-widest text-slate-500 mb-1 italic">Promotion Readiness Protocol</span>
                                            <span class="text-[9px] font-bold text-yellow-500/50 uppercase">{{ $totalStats }} / {{ $required }} Accumulated combat data</span>
                                        </div>
                                        @if($pigeon->level < Auth::user()->loft->level)
                                            <button wire:click="levelUp({{ $pigeon->id }})"
                                                @if($totalStats < $required) disabled @endif
                                                class="w-full sm:w-auto px-8 py-3 rounded-2xl font-black font-industrial italic uppercase text-[10px] md:text-xs transition-all
                                                    {{ $totalStats >= $required 
                                                        ? 'bg-white text-black hover:bg-yellow-500 shadow-[0_0_25px_rgba(255,255,255,0.2)]' 
                                                        : 'bg-slate-800 text-slate-500 cursor-not-allowed border border-white/5' }}">
                                                Authorize Promotion
                                            </button>
                                        @else
                                            <div class="px-4 py-2 bg-red-500/10 border border-red-500/20 rounded-xl">
                                                <span class="text-[8px] font-black text-red-500 uppercase italic tracking-widest">Loft Tier Limit Encountered</span>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="w-full h-2 bg-slate-800 rounded-full overflow-hidden p-[2px]">
                                        <div class="h-full bg-gradient-to-r from-yellow-500 to-white transition-all duration-1000 shadow-[0_0_15px_rgba(234,179,8,0.5)] rounded-full" style="width: {{ $progress }}%"></div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
                                    <div class="space-y-5">
                                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] mb-4 flex items-center gap-2">
                                            <span class="w-1 h-3 bg-yellow-500"></span> Combat Performance
                                        </h4>
                                        @foreach(['speed' => 'Velocity', 'endurance' => 'Stamina', 'navigation' => 'Vectoring', 'temperament' => 'Neural', 'loyalty' => 'Linkage', 'intelligence' => 'Processing'] as $stat => $label)
                                            <div class="relative">
                                                <div class="flex justify-between items-end mb-2">
                                                    <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">{{ $label }}</span>
                                                    <div class="flex items-center gap-3">
                                                        @if(isset($statGains[$pigeon->id][$stat]))
                                                            <span class="text-[10px] font-black text-green-500 animate-pulse">+{{ $statGains[$pigeon->id][$stat] }} DATA</span>
                                                        @endif
                                                        <span class="text-xs font-black {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }}">{{ $pigeon->$stat }}</span>
                                                    </div>
                                                </div>
                                                <div class="flex-1 h-1.5 bg-slate-800 rounded-full overflow-hidden shadow-inner">
                                                    <div class="h-full {{ isset($statGains[$pigeon->id][$stat]) ? 'bg-green-500 shadow-[0_0_10px_#22c55e]' : 'bg-yellow-500/80 shadow-[0_0_10px_rgba(234,179,8,0.4)]' }} transition-all duration-1000" style="width: {{ min(100, ($pigeon->$stat / ($pigeon->level * 10)) * 100) }}%"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="space-y-4 bg-white/5 p-6 rounded-[2rem] border border-white/5 h-fit backdrop-blur-md">
                                        <h4 class="text-[10px] font-black text-slate-500 uppercase tracking-[0.3em] text-center mb-6">Visual Aesthetic Profile</h4>
                                        <div class="grid grid-cols-2 gap-x-6 gap-y-4">
                                            @foreach(['eyes' => 'OPTIC', 'beak' => 'AXIS', 'legs' => 'DRIVE', 'feather_quality' => 'SHELL', 'pattern' => 'MATRIX', 'color' => 'CHROMA', 'purity' => 'CORE'] as $stat => $label)
                                                <div class="flex flex-col border-b border-white/5 pb-2">
                                                    <div class="flex justify-between items-center">
                                                        <span class="text-[7px] md:text-[8px] text-slate-500 uppercase font-black tracking-widest">{{ $label }}</span>
                                                        <div class="flex items-center gap-1">
                                                            @if(isset($statGains[$pigeon->id][$stat]))
                                                                <span class="text-[8px] font-black text-green-500">+{{ $statGains[$pigeon->id][$stat] }}</span>
                                                            @endif
                                                            <span class="text-[10px] {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }} font-black">{{ number_format($pigeon->$stat, 1) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="mt-6 pt-4 border-t border-white/5 text-center">
                                            <span class="text-[8px] font-black text-slate-500 uppercase tracking-[0.2em] block mb-1">Aesthetic Grade</span>
                                            <span class="text-3xl font-industrial font-black text-yellow-500 italic">{{ $pigeon->stat_grades['beauty'] }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Footer Info -->
                            <div class="px-8 py-3 bg-black/40 flex justify-between items-center border-t border-white/5">
                                <div class="flex gap-4">
                                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest italic flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-slate-600"></span> Status: {{ strtoupper($pigeon->status) }}</span>
                                    <span class="text-[8px] font-black text-slate-600 uppercase tracking-widest italic flex items-center gap-2"><span class="w-1 h-1 rounded-full bg-slate-600"></span> Deploy Age: {{ $pigeon->birth_at ? $pigeon->birth_at->diffInDays(now()) : 0 }} Cycles</span>
                                </div>
                                <span class="text-[7px] font-black text-slate-700 uppercase tracking-[0.3em]">SECURE LINK ACTIVE</span>
                            </div>
                        </div>
                    @empty
                        <div class="p-20 border-2 border-dashed border-white/5 rounded-[3rem] text-center bg-black/20">
                            <p class="font-industrial font-black text-slate-800 text-2xl uppercase italic tracking-widest">Select Personnel to view analytics</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
