<div class="space-y-8 font-sans text-slate-300">
    @php
        $summaryStats = [
            'speed' => 'SPD',
            'endurance' => 'END',
            'navigation' => 'NAV',
            'temperament' => 'TMP',
            'loyalty' => 'LOY',
            'intelligence' => 'INT',
        ];

        $summaryTotals = [];
        foreach ($statGains as $birdGains) {
            foreach ($birdGains as $stat => $gain) {
                $summaryTotals[$stat] = ($summaryTotals[$stat] ?? 0) + $gain;
            }
        }
        $totalGainCount = array_sum(array_map('count', $statGains));
    @endphp

    <!-- Notifications -->
    <div class="fixed top-20 right-4 z-50 flex flex-col gap-2">
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                 class="rounded-xl border-2 border-white/20 bg-aviary-blue px-6 py-3 font-industrial italic text-white shadow-2xl animate-bounce">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                 class="rounded-xl border-2 border-white/20 bg-red-800 px-6 py-3 font-industrial italic text-white shadow-2xl">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <div class="parchment-panel relative overflow-hidden rounded-[3rem] border-2 border-aviary-brass/10 p-6 shadow-2xl galvanized-border md:p-10">
        <div class="pointer-events-none absolute top-0 right-0 p-4 text-4xl font-industrial font-black uppercase italic text-aviary-brass opacity-[0.03] md:p-8 md:text-8xl">
            Exercise
        </div>

        <div class="relative z-10 border-b border-aviary-brass/10 pb-8 mb-10 flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div>
                <h2 class="mb-2 text-2xl font-industrial font-black uppercase italic leading-none tracking-widest text-white md:text-5xl">The Exercise Yard</h2>
                <p class="text-[9px] font-black uppercase italic tracking-[0.4em] text-aviary-brass/60 md:text-[11px]">Loft Readiness & Physical Excellence Regimen</p>
            </div>
            <div class="flex items-center gap-4 rounded-2xl border border-aviary-brass/10 bg-aviary-oak/60 p-3 pr-8 shadow-inner">
                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-aviary-brass text-white shadow-[0_0_15px_rgba(184,134,11,0.3)]">
                    <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-[8px] font-black uppercase italic tracking-widest text-aviary-feather/40">Yard Status</span>
                    <span class="font-industrial font-black uppercase italic text-white">Grade {{ Auth::user()->loft->level }} Access</span>
                </div>
            </div>
        </div>

        <div class="relative z-10 grid grid-cols-1 gap-8 lg:grid-cols-12 md:gap-12">
            <!-- Pigeon Selection -->
            <div class="space-y-6 lg:col-span-3">
                <div class="mb-2 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="h-4 w-1 bg-aviary-blue"></div>
                        <h3 class="text-[10px] font-black uppercase italic tracking-[0.2em] text-white">Unit Selection</h3>
                    </div>
                    @if($pigeons->count() > 0)
                        @php
                            $allIds = $pigeons->pluck('id')->map(fn($id) => (string) $id)->toArray();
                            $allSelected = count($allIds) > 0 && count(array_diff($allIds, $selectedPigeonIds)) === 0;
                        @endphp
                        <button type="button" wire:click="toggleSelectAll" class="text-[9px] font-black uppercase tracking-wider text-aviary-brass transition-colors duration-300 hover:text-white">
                            {{ $allSelected ? 'Deselect All' : 'Select All' }}
                        </button>
                    @endif
                </div>

                <div class="max-h-[40vh] space-y-3 overflow-y-auto rounded-3xl border border-aviary-brass/10 bg-aviary-oak/40 p-4 pr-2 shadow-inner custom-scrollbar lg:max-h-[65vh]">
                    @foreach($pigeons as $pigeon)
                        <label class="group flex cursor-pointer items-center justify-between gap-4 rounded-2xl border-2 p-4 transition-all duration-300 {{ in_array($pigeon->id, $selectedPigeonIds) ? 'border-aviary-blue bg-aviary-blue text-white shadow-lg' : 'border-transparent bg-aviary-oak/60 text-white hover:border-aviary-brass/30' }}">
                            <div class="flex min-w-0 items-center gap-4 truncate">
                                <input type="checkbox" wire:model.live="selectedPigeonIds" value="{{ $pigeon->id }}" class="hidden">
                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-white/5 bg-black/40 font-industrial text-xs font-black italic">
                                    {{ $pigeon->level }}
                                </div>
                                <div class="flex min-w-0 flex-col truncate">
                                    <span class="truncate text-xs font-black uppercase italic">{{ $pigeon->name }}</span>
                                    <x-pigeon.registry-meta :pigeon="$pigeon" size="sm" :show-price="false" class="mt-1" />
                                    <div class="mt-1 flex flex-wrap items-center gap-2">
                                        <span class="text-[8px] font-black uppercase italic text-aviary-brass">LOY: {{ $pigeon->loyalty }}%</span>
                                        <span class="h-1 w-1 rounded-full bg-aviary-brass/30"></span>
                                        <span class="text-[8px] font-bold uppercase tracking-tighter opacity-50">{{ $pigeon->type }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="shrink-0">
                                @if(in_array($pigeon->id, $selectedPigeonIds))
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                    </svg>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Main Workbench -->
            <div class="space-y-8 md:space-y-12 lg:col-span-9">
                <div class="sticky top-6 z-20 rounded-[2.5rem] border border-aviary-brass/20 bg-black/45 p-5 shadow-[0_20px_70px_rgba(0,0,0,0.35)] backdrop-blur-xl md:p-6">
                    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <p class="text-[9px] font-black uppercase italic tracking-[0.35em] text-aviary-blue">Training results</p>
                            <h3 class="mt-1 text-2xl font-industrial font-black uppercase italic tracking-tight text-white">Impact ledger</h3>
                            <p class="mt-2 text-[10px] font-black uppercase italic tracking-[0.25em] text-aviary-feather/40">
                                {{ $totalGainCount > 0 ? $totalGainCount . ' attribute gains recorded across ' . count($statGains) . ' birds.' : 'No training gains recorded yet.' }}
                            </p>
                        </div>

                        <div class="grid grid-cols-2 gap-2 sm:grid-cols-3 xl:grid-cols-6">
                            @foreach($summaryStats as $stat => $abbr)
                                <div class="rounded-2xl border border-white/10 bg-white/5 px-3 py-3 text-center">
                                    <span class="block text-[8px] font-black uppercase italic tracking-[0.25em] text-aviary-feather/35">{{ $abbr }}</span>
                                    <span class="mt-1 block font-mono text-lg font-bold {{ ($summaryTotals[$stat] ?? 0) > 0 ? 'text-green-400' : 'text-white/35' }}">+{{ $summaryTotals[$stat] ?? 0 }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    @if(!empty($statGains))
                        <div class="mt-5 max-h-40 overflow-y-auto pr-2 custom-scrollbar">
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedPigeons as $pigeon)
                                    @if(isset($statGains[$pigeon->id]))
                                        <a href="#trained-{{ $pigeon->id }}" class="rounded-full border border-aviary-blue/20 bg-aviary-blue/10 px-4 py-2 text-[9px] font-black uppercase tracking-[0.2em] text-white transition hover:bg-aviary-blue/20">
                                            {{ $pigeon->name }}
                                            @foreach($statGains[$pigeon->id] as $stat => $gain)
                                                <span class="ml-2 text-green-400">+{{ $gain }} {{ $summaryStats[$stat] ?? strtoupper($stat) }}</span>
                                            @endforeach
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                    @foreach([
                        ['type' => 'flight', 'label' => 'Flight Exercise', 'desc' => 'Endurance & Loyalty', 'cost' => '20 Energy'],
                        ['type' => 'distance', 'label' => 'Homing Drill', 'desc' => 'Speed & Navigation', 'cost' => '20 Energy'],
                        ['type' => 'grooming', 'label' => 'Feather Care', 'desc' => 'Appearance & Quality', 'cost' => number_format($totalCost) . ' COINS'],
                        ['type' => 'physical_care', 'label' => 'Health Care', 'desc' => 'Structure & Vitality', 'cost' => number_format($totalCost) . ' COINS'],
                        ['type' => 'gene_therapy', 'label' => 'Bloodline Care', 'desc' => 'Purity Enhancement', 'cost' => number_format($totalCost) . ' COINS'],
                    ] as $cmd)
                        <button wire:click="train('{{ $cmd['type'] }}')"
                                class="group relative overflow-hidden rounded-[2rem] border border-aviary-brass/10 bg-aviary-oak/60 p-6 text-left shadow-xl transition-all duration-500 active:scale-95 hover:bg-aviary-blue galvanized-border">
                            <div class="absolute right-0 top-0 -mr-12 -mt-12 h-24 w-24 rounded-full bg-white/5 blur-2xl transition-colors group-hover:bg-black/10"></div>
                            <div class="relative z-10 flex h-full flex-col justify-between">
                                <div>
                                    <span class="mb-2 block text-[8px] font-black uppercase italic tracking-widest text-aviary-feather/40 group-hover:text-white">{{ $cmd['desc'] }}</span>
                                    <h4 class="text-sm font-industrial font-black uppercase italic tracking-tighter text-white md:text-base">{{ $cmd['label'] }}</h4>
                                </div>
                                <div class="mt-8 flex items-end justify-between border-t border-aviary-brass/10 pt-4 group-hover:border-white/20">
                                    <span class="text-[10px] font-mono font-bold uppercase italic text-aviary-brass group-hover:text-white">{{ $cmd['cost'] }}</span>
                                    <svg class="h-4 w-4 text-aviary-feather/40 group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </div>
                            </div>
                        </button>
                    @endforeach

                    <button wire:click="restAll"
                            class="flex flex-col items-center justify-center gap-3 rounded-[2rem] border-2 border-dashed border-aviary-brass/20 bg-aviary-oak/40 p-6 text-center shadow-inner transition-all duration-500 hover:border-aviary-blue/40 hover:bg-aviary-blue/5">
                        <svg class="h-10 w-10 text-emerald-400 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 3c3.9 0 7 3.1 7 7 0 2.3-1.1 4.4-2.8 5.7L12 21l-4.2-5.3C6.1 14.4 5 12.3 5 10c0-3.9 3.1-7 7-7z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.5 10.5h5" />
                        </svg>
                        <div class="flex flex-col">
                            <span class="font-industrial text-xs font-black uppercase italic text-white">Full Recovery</span>
                            <span class="mt-1 text-[9px] font-mono font-bold uppercase italic tracking-widest text-emerald-400">{{ $restCost * count($selectedPigeonIds) }} VITAMINS TOTAL</span>
                        </div>
                    </button>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center gap-3">
                        <div class="h-4 w-1 bg-aviary-brass"></div>
                        <h3 class="text-[10px] font-black uppercase italic tracking-[0.2em] text-white">Physical Analytics</h3>
                    </div>

                    <div class="grid grid-cols-1 gap-8">
                        @forelse($selectedPigeons as $pigeon)
                            <div id="trained-{{ $pigeon->id }}" class="group relative scroll-mt-32 overflow-hidden rounded-[3rem] border-2 border-aviary-brass/10 bg-aviary-oak/60 shadow-2xl transition-all duration-500 hover:border-aviary-blue/30 galvanized-border">
                                <div class="relative border-b border-aviary-brass/10 bg-gradient-to-r from-aviary-timber to-aviary-oak p-6">
                                    <div class="pointer-events-none absolute top-0 right-0 p-4 text-4xl font-industrial font-black uppercase italic text-aviary-brass opacity-[0.03]">{{ $pigeon->type }}</div>

                                    <div class="relative z-10 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                                        <div class="flex items-center gap-6">
                                            <div class="relative shrink-0">
                                                <div class="absolute inset-0 animate-pulse rounded-2xl bg-aviary-blue/10"></div>
                                                <div class="relative flex h-16 w-16 items-center justify-center rounded-2xl border border-aviary-brass/20 bg-aviary-timber text-3xl shadow-inner">
                                                    🕊
                                                </div>
                                                <div class="absolute -left-2 -top-2 rounded shadow-lg bg-aviary-blue px-2 py-0.5 text-[10px] font-industrial font-black italic text-white">
                                                    LV.{{ $pigeon->level }}
                                                </div>
                                            </div>

                                            <div>
                                                <h4 class="mb-2 text-xl font-industrial font-black uppercase italic leading-none tracking-tighter text-white md:text-3xl">{{ $pigeon->name }}</h4>
                                                <x-pigeon.registry-meta :pigeon="$pigeon" size="sm" class="mb-3" />
                                                <div class="flex flex-wrap gap-2">
                                                    <span class="rounded-full border px-3 py-1 text-[9px] font-black uppercase tracking-widest {{ $pigeon->gender == 'male' ? 'bg-aviary-blue/20 text-aviary-blue border-aviary-blue/20' : 'bg-aviary-rose/20 text-aviary-rose border-aviary-rose/20' }}">
                                                        {{ $pigeon->gender == 'male' ? '♂ COCK' : '♀ HEN' }}
                                                    </span>
                                                    @if(isset($statGains[$pigeon->id]))
                                                        <span class="rounded-full border border-green-500/20 bg-green-500/10 px-3 py-1 text-[9px] font-black uppercase tracking-widest text-green-300">
                                                            Updated
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>

                                        <div class="min-w-[140px] rounded-2xl border border-aviary-brass/10 bg-black/40 p-4 shadow-inner text-left sm:text-right">
                                            <span class="mb-2 block text-[10px] font-black uppercase italic tracking-widest text-aviary-feather/40">Condition Ring</span>
                                            <div class="flex items-center gap-4 sm:justify-end">
                                                <span class="text-2xl font-mono font-bold text-white">{{ $pigeon->energy }}%</span>
                                                <div class="relative h-8 w-8">
                                                    <svg class="h-8 w-8 -rotate-90 transform">
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

                                    @if(isset($statGains[$pigeon->id]))
                                        <div class="relative z-10 mt-5 flex flex-wrap gap-2">
                                            @foreach($statGains[$pigeon->id] as $stat => $gain)
                                                <span class="rounded-full border border-green-500/20 bg-green-500/10 px-3 py-1 text-[9px] font-black uppercase tracking-widest text-green-300">
                                                    +{{ $gain }} {{ $summaryStats[$stat] ?? strtoupper($stat) }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <div class="space-y-10 p-6 md:p-8">
                                    @php
                                        $totalStats = $pigeon->speed + $pigeon->endurance + $pigeon->navigation + $pigeon->temperament;
                                        $required = $pigeon->required_stats;
                                        $progress = min(100, ($totalStats / ($required ?: 1)) * 100);
                                        $loftLevel = Auth::user()->loft->level;
                                    @endphp

                                    <div class="rounded-[2rem] border border-aviary-brass/10 bg-black/30 p-6 shadow-inner">
                                        <div class="mb-6 flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
                                            <div class="flex flex-col">
                                                <span class="mb-1 text-[11px] font-black uppercase italic tracking-widest text-aviary-feather/40">Promotion Registry</span>
                                                <span class="text-[10px] font-mono font-bold uppercase italic text-aviary-brass/60">{{ $totalStats }} / {{ $required }} Accumulated XP</span>
                                            </div>
                                            @if($pigeon->level < $loftLevel)
                                                <button wire:click="levelUp({{ $pigeon->id }})"
                                                        @if($totalStats < $required) disabled @endif
                                                        class="w-full rounded-2xl border border-white/10 px-10 py-3 font-industrial text-xs font-black uppercase italic shadow-xl transition-all sm:w-auto
                                                        {{ $totalStats >= $required ? 'bg-aviary-brass text-white hover:bg-aviary-blue' : 'cursor-not-allowed border-white/5 bg-aviary-timber/50 text-aviary-feather/20' }}">
                                                    Authorize Rank Up
                                                </button>
                                            @else
                                                <div class="flex items-center gap-3 rounded-2xl border border-red-500/20 bg-red-950/20 px-6 py-3">
                                                    <span class="h-1.5 w-1.5 rounded-full bg-red-600 animate-pulse"></span>
                                                    <span class="text-[9px] font-black uppercase italic tracking-widest text-red-500">Loft Level Limit Reached</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="h-2.5 w-full overflow-hidden rounded-full border border-white/5 bg-aviary-oak p-[1px] shadow-inner">
                                            <div class="h-full rounded-full bg-gradient-to-r from-aviary-brass to-white shadow-[0_0_15px_rgba(184,134,11,0.4)] transition-all duration-1000" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 gap-10 font-mono md:grid-cols-2 md:gap-16">
                                        <div class="space-y-6">
                                            <h4 class="mb-6 flex items-center gap-3 text-[11px] font-black uppercase italic tracking-[0.3em] text-aviary-feather/40">
                                                <span class="h-1.5 w-1.5 rounded-full bg-aviary-brass"></span> Performance Matrix
                                            </h4>
                                            @foreach(['speed' => 'SPD', 'endurance' => 'END', 'navigation' => 'NAV', 'temperament' => 'TMP', 'loyalty' => 'LOY', 'intelligence' => 'INT'] as $stat => $abbr)
                                                <div class="relative">
                                                    <div class="mb-2 flex items-end justify-between">
                                                        <span class="text-[10px] font-bold uppercase italic tracking-widest text-aviary-feather/60">{{ $abbr }}</span>
                                                        <div class="flex items-center gap-3">
                                                            @if(isset($statGains[$pigeon->id][$stat]))
                                                                <span class="animate-pulse text-[10px] font-bold text-green-500">+{{ $statGains[$pigeon->id][$stat] }}</span>
                                                            @endif
                                                            <span class="text-xs font-bold {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }}">{{ $pigeon->$stat }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="h-1 overflow-hidden rounded-full bg-aviary-oak shadow-inner">
                                                        <div class="h-full transition-all duration-1000 {{ isset($statGains[$pigeon->id][$stat]) ? 'bg-green-600 shadow-[0_0_10px_#16a34a]' : ($stat === 'intelligence' ? 'bg-aviary-blue' : 'bg-aviary-brass/80') }}"
                                                             style="width: {{ min(100, ($pigeon->$stat / (in_array($stat, ['loyalty', 'intelligence']) ? 100 : ($pigeon->level * 10 ?: 10))) * 100) }}%"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        <div class="h-fit space-y-6 rounded-[2.5rem] border border-aviary-brass/10 bg-aviary-timber/30 p-8 shadow-inner backdrop-blur-sm">
                                            <h4 class="text-center text-[11px] font-black uppercase italic tracking-[0.3em] text-aviary-feather/40">Appearance Grade</h4>
                                            <div class="grid grid-cols-2 gap-x-8 gap-y-5">
                                                @foreach(['eyes' => 'EYE', 'beak' => 'BEK', 'legs' => 'LEG', 'feather_quality' => 'FTH', 'pattern' => 'PAT', 'color' => 'CLR', 'purity' => 'BLO'] as $stat => $abbr)
                                                    <div class="flex flex-col border-b border-white/5 pb-2">
                                                        <div class="flex items-center justify-between">
                                                            <span class="text-[9px] font-bold uppercase italic tracking-widest text-aviary-feather/40">{{ $abbr }}</span>
                                                            <div class="flex items-center gap-2">
                                                                @if(isset($statGains[$pigeon->id][$stat]))
                                                                    <span class="text-[9px] font-bold text-green-500">+{{ $statGains[$pigeon->id][$stat] }}</span>
                                                                @endif
                                                                <span class="text-xs font-bold {{ isset($statGains[$pigeon->id][$stat]) ? 'text-green-500' : 'text-white' }}">{{ number_format($pigeon->$stat, 1) }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="mt-8 border-t border-aviary-brass/10 pt-6 text-center">
                                                <span class="mb-2 block text-[9px] font-black uppercase italic tracking-[0.2em] text-aviary-feather/40">Official Score</span>
                                                <span class="text-5xl font-industrial font-black italic text-aviary-brass trophy-gold">{{ $pigeon->stat_grades['beauty'] }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="relative overflow-hidden border-t border-aviary-brass/10 bg-aviary-timber/60 px-8 py-5">
                                    <div class="absolute inset-0 bg-gradient-to-r from-aviary-blue/5 to-transparent"></div>
                                    <div class="relative z-10 flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                                        <div class="flex flex-wrap gap-8">
                                            <span class="flex items-center gap-3 text-[10px] font-bold uppercase italic tracking-widest text-aviary-feather/40">
                                                <span class="h-1.5 w-1.5 rounded-full bg-aviary-blue/40"></span>
                                                Duty: {{ $pigeon->status }}
                                            </span>
                                            <span class="flex items-center gap-3 text-[10px] font-bold uppercase italic tracking-widest text-aviary-feather/40">
                                                <span class="h-1.5 w-1.5 rounded-full bg-aviary-brass/40"></span>
                                                Age: {{ $pigeon->birth_at ? $pigeon->birth_at->diffInDays(now()) : 0 }} Days
                                            </span>
                                        </div>
                                        <span class="text-[8px] font-black uppercase italic tracking-[0.4em] text-aviary-feather/20">Registry Verified | Yard Ready</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[4rem] border-2 border-dashed border-aviary-brass/10 bg-aviary-oak/10 py-32 text-center">
                                <div class="mb-8 text-6xl opacity-10">🕊</div>
                                <p class="font-industrial text-xl font-black uppercase italic tracking-[0.3em] text-aviary-feather/20 md:text-3xl">No Units Selected for Analysis</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
