@php
    $raceTypeLabel = match ($race->race_type) {
        'exhibition' => 'Exhibition Circuit',
        'highflyer' => 'High Flyer Circuit',
        default => 'Racing Circuit',
    };

    $raceTypeCopy = match ($race->race_type) {
        'exhibition' => 'Judges are scoring form, poise, and genetic quality.',
        'highflyer' => 'Altitude, stamina, and navigation are being measured.',
        default => 'Speed, endurance, and clean lines decide the winner.',
    };

    $raceRewardUnit = match($race->race_type) {
        'exhibition' => 'tokens',
        'highflyer'  => 'vitamins',
        default      => 'coins',
    };

    $entryFeeUnit = 'tokens';

    $playerResults = $results ? $results->whereIn('pigeon_id', $pigeonIds) : collect();
@endphp

<div
    class="max-w-7xl mx-auto p-4 md:p-6 text-slate-200"
    wire:init="startSimulation"
    x-data="{ simulating: @entangle('isSimulating').live, revealResults: false }"
    x-init="$watch('simulating', value => { if (!value) { revealResults = false; setTimeout(() => revealResults = true, 2200) } })"
>
    <div class="relative overflow-hidden rounded-[3rem] border border-white/10 bg-[linear-gradient(180deg,rgba(15,23,42,0.94),rgba(2,6,23,0.98))] shadow-[0_30px_120px_rgba(0,0,0,0.45)]">
        <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.12),transparent_45%),linear-gradient(135deg,rgba(59,130,246,0.08),transparent_35%,rgba(212,175,55,0.10))]"></div>

        <div class="relative z-10 p-6 md:p-10">
            <div class="flex flex-col gap-6 xl:flex-row xl:items-end xl:justify-between mb-8">
                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.3em] bg-white/8 border border-white/10 text-white/80">
                            Live Calculation Field
                        </span>
                        <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-[0.3em] bg-aviary-brass/15 border border-aviary-brass/30 text-aviary-brass">
                            {{ $raceTypeLabel }}
                        </span>
                    </div>

                    <div class="space-y-2">
                        <h2 class="text-3xl md:text-5xl font-industrial font-black uppercase italic tracking-tight text-white leading-none">
                            {{ $race->title }}
                        </h2>
                        <p class="max-w-3xl text-sm md:text-base text-slate-300/80 leading-relaxed">
                            {{ $raceTypeCopy }}
                        </p>
                    </div>
                </div>

                <div class="flex flex-col gap-3 text-sm text-slate-300/80">
                    <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-5 py-4 backdrop-blur">
                        <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Race Length</p>
                        <p class="text-xl font-black text-white">{{ number_format($race->distance_km, 1) }} KM</p>
                    </div>
                    <div class="rounded-[1.5rem] border border-white/10 bg-white/5 px-5 py-4 backdrop-blur">
                        <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Prize Pool</p>
                        <p class="text-xl font-black text-aviary-brass trophy-gold">{{ number_format($race->prize_pool) }} {{ $raceRewardUnit }}</p>
                    </div>
                </div>
            </div>

            @if($isSimulating)
                <div class="grid gap-6 xl:grid-cols-[1.25fr_0.9fr] items-stretch">
                    <div class="relative overflow-hidden rounded-[2.5rem] border border-white/10 bg-[linear-gradient(180deg,rgba(14,165,233,0.16),rgba(15,23,42,0.95)_34%,rgba(20,83,45,0.9)_100%)] min-h-[32rem] shadow-2xl">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(255,255,255,0.16),transparent_24%),radial-gradient(circle_at_80%_25%,rgba(255,255,255,0.08),transparent_20%),linear-gradient(180deg,rgba(255,255,255,0.04),transparent_28%)]"></div>

                        @if($race->race_type !== 'exhibition')
                            <div class="absolute left-6 top-6 z-20">
                                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-slate-200/70 mb-2">Field Status</p>
                                <h3 class="text-2xl md:text-3xl font-black italic text-white uppercase leading-none">Calculating flight lines</h3>
                            </div>

                            <div class="absolute inset-x-6 top-24 bottom-28 rounded-[2rem] border border-white/10 bg-black/20 backdrop-blur-sm overflow-hidden">
                                <div class="absolute inset-0 bg-[linear-gradient(180deg,rgba(255,255,255,0.03),transparent_20%),linear-gradient(90deg,transparent_0_14%,rgba(255,255,255,0.05)_14%_15%,transparent_15%_29%,rgba(255,255,255,0.05)_29%_30%,transparent_30%_44%,rgba(255,255,255,0.05)_44%_45%,transparent_45%_59%,rgba(255,255,255,0.05)_59%_60%,transparent_60%_74%,rgba(255,255,255,0.05)_74%_75%,transparent_75%_100%)] opacity-60"></div>

                                <div class="absolute inset-x-6 top-6 flex items-center justify-between text-[10px] font-black uppercase tracking-[0.35em] text-slate-300/50">
                                    <span>Start Gate</span>
                                    <span>Finish Line</span>
                                </div>

                                <div class="absolute inset-x-8 top-[23%] border-t border-dashed border-white/15"></div>
                                <div class="absolute inset-x-8 top-[46%] border-t border-dashed border-white/15"></div>
                                <div class="absolute inset-x-8 top-[69%] border-t border-dashed border-white/15"></div>

                                <div class="absolute left-8 right-8 bottom-6 h-16 rounded-full bg-gradient-to-r from-emerald-900/70 via-emerald-800/55 to-emerald-900/70 border border-emerald-400/10"></div>
                                <div class="absolute left-8 right-8 bottom-14 h-1 rounded-full bg-gradient-to-r from-transparent via-aviary-brass/60 to-transparent animate-race-glow"></div>

                                <div class="absolute inset-0 overflow-hidden">
                                    @foreach([12, 34, 56, 78] as $laneIndex => $laneTop)
                                        <div
                                            class="race-bird absolute left-6 text-white/90"
                                            :style="`top: {{ $laneTop }}%; animation-delay: {{ $laneIndex * 0.65 }}s;`"
                                        >
                                            <div class="flex items-center gap-3">
                                                <div class="flex h-10 w-10 items-center justify-center rounded-full border border-white/10 bg-white/10 text-[10px] font-black uppercase tracking-[0.25em] text-white/70 shadow-lg">
                                                    {{ str_pad((string)($laneIndex + 1), 2, '0', STR_PAD_LEFT) }}
                                                </div>
                                                <svg class="h-14 w-14 drop-shadow-[0_0_20px_rgba(255,255,255,0.35)]" viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                                    <path d="M9 38c7-12 17-19 30-21l7-8 9 8c4 0 7 1 10 3-3 2-6 4-8 7 4 0 8 1 11 4-5 1-10 3-13 6-4 3-6 7-6 12-4-3-8-7-11-12-5 8-12 13-22 15 1-5 1-10 0-15-3 1-7 1-11 1 1-4 2-7 4-10Z" fill="currentColor" opacity="0.96" />
                                                    <path d="M32 18c2 4 2 8 1 12" stroke="rgba(255,255,255,0.55)" stroke-width="2.5" stroke-linecap="round" />
                                                </svg>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @else
                            <div class="absolute left-6 top-6 z-20">
                                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-slate-200/70 mb-2">Exhibition Status</p>
                                <h3 class="text-2xl md:text-3xl font-black italic text-white uppercase leading-none">Judges are scoring</h3>
                            </div>

                            <div class="absolute inset-x-6 top-24 bottom-28 rounded-[2rem] border border-white/10 bg-black/20 backdrop-blur-sm overflow-hidden flex flex-col items-center justify-center">
                                <div class="text-center w-full px-8 space-y-6">
                                    <div class="grid grid-cols-2 gap-6">
                                        @foreach(['Feathering', 'Stance', 'Eye Clarity', 'Color Pattern'] as $criteria)
                                            <div class="px-6 py-4 rounded-2xl bg-white/5 border border-white/10">
                                                <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-3">{{ $criteria }}</p>
                                                <div class="w-full h-2 rounded-full bg-white/10 overflow-hidden">
                                                    <div class="h-full bg-gradient-to-r from-aviary-brass to-amber-200 animate-pulse w-full"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-8">
                                        <p class="text-lg text-white/80 font-black italic uppercase tracking-widest animate-pulse">Evaluating Specimens...</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="absolute inset-x-6 bottom-6 grid gap-3 md:grid-cols-3">
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/6 px-5 py-4 backdrop-blur-sm">
                                <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Difficulty Tier</p>
                                <p class="text-lg font-black text-white">{{ $race->difficulty_tier }}</p>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/6 px-5 py-4 backdrop-blur-sm">
                                <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Entry Fee</p>
                                <p class="text-lg font-black text-white">{{ number_format($race->entry_fee) }} {{ $entryFeeUnit }}</p>
                            </div>
                            <div class="rounded-[1.5rem] border border-white/10 bg-white/6 px-5 py-4 backdrop-blur-sm">
                                <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Status</p>
                                <p class="text-lg font-black text-aviary-brass">Computing results</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-[2.25rem] border border-white/10 bg-white/6 p-6 md:p-7 backdrop-blur-sm shadow-2xl">
                            <p class="text-[10px] uppercase tracking-[0.35em] text-slate-400 font-black mb-3">Race Feed</p>
                            @if($race->race_type !== 'exhibition')
                                <h3 class="text-2xl font-black italic uppercase text-white leading-none mb-4">Pigeon movement locked to the field</h3>
                                <p class="text-sm text-slate-300/80 leading-relaxed mb-6">
                                    Each lane is being resolved against the same race rules you already use. The animation is just the presentation layer, so the result ledger still comes from the normal simulation engine.
                                </p>
                            @else
                                <h3 class="text-2xl font-black italic uppercase text-white leading-none mb-4">Judges are analyzing</h3>
                                <p class="text-sm text-slate-300/80 leading-relaxed mb-6">
                                    The panel is evaluating beauty, pedigree, and form. Final scores will determine the ranking.
                                </p>
                            @endif
                            <div class="space-y-3">
                                <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-3">
                                    <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Field Rules</p>
                                    <p class="text-sm text-white/90">Type: {{ $race->race_type }} | Distance: {{ number_format($race->distance_km, 1) }} KM</p>
                                </div>
                                <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-3">
                                    <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Result Pool</p>
                                    <p class="text-sm text-white/90">Top 3 will be paid automatically in {{ $raceRewardUnit }}.</p>
                                </div>
                            </div>
                        </div>

                        <div class="rounded-[2.25rem] border border-aviary-brass/20 bg-aviary-brass/10 p-6 md:p-7 backdrop-blur-sm">
                            <p class="text-[10px] uppercase tracking-[0.35em] text-aviary-brass font-black mb-2">Tracking Notes</p>
                            <p class="text-sm text-slate-200/80 leading-relaxed">
                                The screen stays open while the simulation resolves. When the ledger lands, the podium will appear here with your pigeon highlighted.
                            </p>
                        </div>
                    </div>
                </div>
            @else
                <div
                    class="space-y-6"
                    x-cloak
                    x-show="revealResults"
                    x-transition.opacity.duration.700ms
                    x-transition.scale.duration.700ms
                >
                    <div class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr] items-start">
                        <div class="rounded-[2.5rem] border border-white/10 bg-white/5 p-6 md:p-8 shadow-2xl">
                            <div class="flex items-center justify-between gap-4 flex-wrap mb-6">
                                <div>
                                    <p class="text-[10px] uppercase tracking-[0.35em] text-slate-400 font-black mb-2">Result Ledger</p>
                                    <h3 class="text-2xl md:text-3xl font-black italic uppercase text-white leading-none">Final standings</h3>
                                </div>
                                <div class="px-4 py-2 rounded-full border border-aviary-brass/20 bg-aviary-brass/10 text-[10px] font-black uppercase tracking-[0.3em] text-aviary-brass">
                                    {{ count($results) }} competitors
                                </div>
                            </div>

                            @foreach($playerResults as $playerResult)
                                <div class="rounded-[2rem] border border-aviary-blue/30 bg-aviary-blue/10 p-5 md:p-6 mb-6 shadow-lg">
                                    <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                                        <div>
                                            <p class="text-[10px] uppercase tracking-[0.35em] text-aviary-blue font-black mb-2">Your Pigeon</p>
                                            <h4 class="text-2xl font-black italic uppercase text-white leading-none">{{ $playerResult->pigeon->name ?? 'Your pigeon' }}</h4>
                                        </div>
                                        <div class="flex flex-wrap gap-3 text-sm">
                                            <span class="px-4 py-2 rounded-full bg-black/30 border border-white/10 text-white/80 font-black uppercase tracking-[0.2em]">
                                                Place #{{ $playerResult->position }}
                                            </span>
                                            <span class="px-4 py-2 rounded-full bg-black/30 border border-white/10 text-white/80 font-black uppercase tracking-[0.2em]">
                                                {{ $race->race_type === 'exhibition' ? number_format($playerResult->pigeon->beauty, 2) . ' PTS' : ($race->race_type === 'highflyer' ? gmdate('H:i:s', (int) $playerResult->finish_time_seconds) . ' flight' : gmdate('H:i:s', (int) $playerResult->finish_time_seconds)) }}
                                            </span>
                                            <span class="px-4 py-2 rounded-full bg-black/30 border border-white/10 text-white/80 font-black uppercase tracking-[0.2em]">
                                                +{{ number_format($playerResult->payout) }} {{ $raceRewardUnit }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <div class="grid gap-4 md:grid-cols-3 mb-6">
                                @foreach($results->take(3) as $podiumResult)
                                    <div class="rounded-[2rem] border {{ in_array($podiumResult->pigeon_id, $pigeonIds) ? 'border-aviary-blue/40 bg-aviary-blue/10' : 'border-white/10 bg-black/20' }} p-5 shadow-xl">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="text-3xl font-black italic uppercase {{ $podiumResult->position === 1 ? 'text-aviary-brass' : 'text-white' }}">
                                                #{{ $podiumResult->position }}
                                            </div>
                                            <div class="h-10 w-10 rounded-full flex items-center justify-center font-black text-sm {{ $podiumResult->position === 1 ? 'bg-aviary-brass text-white' : 'bg-white/10 text-white/80' }}">
                                                {{ $podiumResult->position }}
                                            </div>
                                        </div>
                                        <div class="space-y-2">
                                            <p class="text-lg font-black italic uppercase text-white leading-none">{{ $podiumResult->pigeon->name ?? 'Unregistered pigeon' }}</p>
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black">
                                                {{ $race->race_type === 'exhibition' ? number_format($podiumResult->pigeon->beauty, 2) . ' PTS' : ($race->race_type === 'highflyer' ? gmdate('H:i:s', (int) $podiumResult->finish_time_seconds) . ' flight' : gmdate('H:i:s', (int) $podiumResult->finish_time_seconds)) }}
                                            </p>
                                            <p class="text-sm font-black text-aviary-brass">
                                                +{{ number_format($podiumResult->payout) }} {{ $raceRewardUnit }}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="space-y-3">
                                @foreach($results as $result)
                                    <div class="flex flex-col gap-4 rounded-[1.75rem] border px-5 py-4 md:flex-row md:items-center md:justify-between {{ in_array($result->pigeon_id, $pigeonIds) ? 'border-aviary-blue/35 bg-aviary-blue/10' : 'border-white/10 bg-white/5' }}">
                                        <div class="flex items-center gap-4">
                                            <div class="flex h-12 w-12 items-center justify-center rounded-2xl {{ $result->position === 1 ? 'bg-aviary-brass text-white' : 'bg-black/30 text-white/80' }} font-black text-lg">
                                                {{ $result->position }}
                                            </div>
                                            <div>
                                                <p class="text-base md:text-lg font-black italic uppercase text-white leading-none">
                                                    {{ $result->pigeon->name ?? 'Unregistered pigeon' }}
                                                </p>
                                                <p class="mt-1 text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black">
                                                    {{ $race->race_type === 'exhibition' ? 'Beauty score ' . number_format($result->pigeon->beauty, 2) : ($race->race_type === 'highflyer' ? 'Flight duration ' . gmdate('H:i:s', (int) $result->finish_time_seconds) : 'Finish time ' . gmdate('H:i:s', (int) $result->finish_time_seconds)) }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap items-center gap-3 text-sm">
                                            @if(in_array($result->pigeon_id, $pigeonIds))
                                                <span class="px-4 py-2 rounded-full bg-aviary-blue text-white font-black uppercase tracking-[0.25em] text-[10px]">
                                                    Your bird
                                                </span>
                                            @endif
                                            <span class="px-4 py-2 rounded-full border border-white/10 bg-black/30 text-white/80 font-black uppercase tracking-[0.25em] text-[10px]">
                                                +{{ number_format($result->payout) }} {{ $raceRewardUnit }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="space-y-6">
                            <div class="rounded-[2.5rem] border border-white/10 bg-white/5 p-6 md:p-8 shadow-2xl">
                                <p class="text-[10px] uppercase tracking-[0.35em] text-slate-400 font-black mb-3">Race Summary</p>
                                <h3 class="text-2xl font-black italic uppercase text-white leading-none mb-4">Official readout</h3>
                                <div class="space-y-3">
                                    <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-3">
                                        <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Type</p>
                                        <p class="text-sm text-white/90">{{ $raceTypeLabel }}</p>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-3">
                                        <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Distance</p>
                                        <p class="text-sm text-white/90">{{ number_format($race->distance_km, 1) }} KM</p>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-3">
                                        <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Payout Unit</p>
                                        <p class="text-sm text-white/90">{{ strtoupper($raceRewardUnit) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="rounded-[2.5rem] border border-aviary-brass/20 bg-aviary-brass/10 p-6 md:p-8 shadow-2xl">
                                <p class="text-[10px] uppercase tracking-[0.35em] text-aviary-brass font-black mb-3">Next Move</p>
                                <h3 class="text-2xl font-black italic uppercase text-white leading-none mb-4">Run the same race type again</h3>
                                <p class="text-sm text-slate-200/80 leading-relaxed mb-6">
                                    Jump back to the tournament board filtered to {{ strtolower($raceTypeLabel) }} so you can start another attempt fast.
                                </p>
                                <div class="flex flex-col gap-3">
                                    <button
                                        wire:click="redoRace"
                                        class="group inline-flex items-center justify-center rounded-[1.5rem] border border-white/10 bg-white px-6 py-4 text-sm font-black uppercase tracking-[0.25em] text-black transition-all hover:bg-aviary-blue hover:text-white shadow-xl"
                                    >
                                        <span class="group-hover:scale-[1.02] transition-transform">Redo {{ $raceTypeLabel }}</span>
                                    </button>
                                    <a
                                        href="{{ route('dashboard') }}"
                                        class="inline-flex items-center justify-center rounded-[1.5rem] border border-white/10 bg-black/20 px-6 py-4 text-sm font-black uppercase tracking-[0.25em] text-white/80 transition-all hover:bg-white/10 hover:text-white"
                                    >
                                        Return to Dashboard
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div
                    x-cloak
                    x-show="!revealResults && !simulating"
                    x-transition.opacity.duration.300ms
                    class="grid gap-6 xl:grid-cols-[1.15fr_0.85fr] items-start"
                >
                    <div class="rounded-[2.5rem] border border-white/10 bg-white/5 p-6 md:p-8 shadow-2xl min-h-[28rem] overflow-hidden relative">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,rgba(255,255,255,0.08),transparent_35%),linear-gradient(135deg,rgba(59,130,246,0.08),transparent_40%,rgba(184,134,11,0.10))]"></div>
                        <div class="relative z-10 flex h-full flex-col justify-between">
                            <div class="space-y-4">
                                <p class="text-[10px] uppercase tracking-[0.35em] text-slate-400 font-black">Calculation Bridge</p>
                                <h3 class="text-2xl md:text-3xl font-black italic uppercase text-white leading-none">Locking the ledger</h3>
                                <p class="text-sm text-slate-300/80 max-w-xl leading-relaxed">
                                    The birds have crossed the line. Final ordering, payout resolution, and status updates are being committed now.
                                </p>
                            </div>

                            <div class="space-y-5">
                                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                    @if($race->race_type !== 'exhibition')
                                        <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-2">Speed Matrix</p>
                                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full w-4/5 bg-gradient-to-r from-aviary-blue to-white animate-pulse"></div>
                                            </div>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-2">Fatigue Curve</p>
                                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full w-2/3 bg-gradient-to-r from-aviary-brass to-white animate-pulse"></div>
                                            </div>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-2">Navigation Drift</p>
                                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full w-1/2 bg-gradient-to-r from-emerald-400 to-white animate-pulse"></div>
                                            </div>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-2">Payout Queue</p>
                                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full w-3/4 bg-gradient-to-r from-aviary-rose to-white animate-pulse"></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-2">Aesthetic Check</p>
                                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full w-4/5 bg-gradient-to-r from-aviary-blue to-white animate-pulse"></div>
                                            </div>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-2">Form Evaluation</p>
                                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full w-2/3 bg-gradient-to-r from-aviary-brass to-white animate-pulse"></div>
                                            </div>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-2">Poise Scoring</p>
                                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full w-1/2 bg-gradient-to-r from-emerald-400 to-white animate-pulse"></div>
                                            </div>
                                        </div>
                                        <div class="rounded-2xl border border-white/10 bg-black/25 p-4">
                                            <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-2">Payout Queue</p>
                                            <div class="h-2 rounded-full bg-white/10 overflow-hidden">
                                                <div class="h-full w-3/4 bg-gradient-to-r from-aviary-rose to-white animate-pulse"></div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <div class="rounded-[1.75rem] border border-white/10 bg-black/25 p-4">
                                    <div class="flex items-center justify-between text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-3">
                                        <span>Finalizing</span>
                                        <span>Updating results</span>
                                    </div>
                                    <div class="h-3 rounded-full bg-white/10 overflow-hidden">
                                        <div class="h-full w-full bg-[length:200%_100%] bg-gradient-to-r from-transparent via-white/80 to-transparent animate-race-scan"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="rounded-[2.25rem] border border-white/10 bg-white/6 p-6 md:p-7 backdrop-blur-sm shadow-2xl">
                            <p class="text-[10px] uppercase tracking-[0.35em] text-slate-400 font-black mb-3">Result Arrival</p>
                            <h3 class="text-2xl font-black italic uppercase text-white leading-none mb-4">Staging the final board</h3>
                            <div class="space-y-3">
                                @foreach([1, 2, 3] as $slot)
                                    <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-3 animate-pulse">
                                        <p class="text-[10px] uppercase tracking-[0.3em] text-slate-400 font-black mb-1">Slot {{ $slot }}</p>
                                        <div class="h-4 w-2/3 rounded-full bg-white/10"></div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="rounded-[2.25rem] border border-aviary-brass/20 bg-aviary-brass/10 p-6 md:p-7 backdrop-blur-sm">
                            <p class="text-[10px] uppercase tracking-[0.35em] text-aviary-brass font-black mb-2">What happens next</p>
                            <p class="text-sm text-slate-200/80 leading-relaxed">
                                The result panel will fade in immediately after the calculation bridge completes, keeping the handoff from lobby to ledger visually continuous.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes race-bird-flight {
            0% {
                transform: translateX(-10%) translateY(0) scale(0.95);
                opacity: 0;
            }
            8% {
                opacity: 1;
            }
            50% {
                transform: translateX(55%) translateY(-10px) scale(1);
                opacity: 1;
            }
            92% {
                opacity: 0.85;
            }
            100% {
                transform: translateX(120%) translateY(2px) scale(0.95);
                opacity: 0;
            }
        }

        @keyframes race-bird-bob {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-6px);
            }
        }

        @keyframes race-glow {
            0% {
                opacity: 0.2;
                transform: translateX(-8%);
            }
            50% {
                opacity: 1;
            }
            100% {
                opacity: 0.2;
                transform: translateX(8%);
            }
        }

        .race-bird {
            animation: race-bird-flight 9s linear infinite, race-bird-bob 1.8s ease-in-out infinite;
            will-change: transform, opacity;
        }

        .animate-race-glow {
            animation: race-glow 2.2s ease-in-out infinite;
        }

        @keyframes race-scan {
            0% {
                transform: translateX(-110%);
            }
            100% {
                transform: translateX(110%);
            }
        }

        .animate-race-scan {
            animation: race-scan 2.6s linear infinite;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
