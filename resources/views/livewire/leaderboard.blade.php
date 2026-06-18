<div class="font-sans text-slate-300 relative" x-data="{}">

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- HERO HEADER                                                  --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="relative overflow-hidden rounded-[3rem] mb-10 parchment-panel border-2 border-aviary-brass/20 shadow-2xl galvanized-border">
        {{-- Ambient glow --}}
        <div class="absolute -top-20 left-1/2 -translate-x-1/2 w-[600px] h-[300px] bg-aviary-brass/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 right-0 w-[400px] h-[300px] bg-aviary-blue/5 rounded-full blur-3xl pointer-events-none"></div>

        {{-- Watermark --}}
        <div class="absolute top-0 right-0 p-8 opacity-[0.025] text-[10rem] font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass leading-none">HOF</div>

        <div class="relative z-10 p-8 md:p-14">
            <div class="flex flex-col lg:flex-row justify-between items-center gap-8">
                {{-- Title --}}
                <div class="flex items-center gap-6">
                    <div class="flex flex-col gap-1.5">
                        <div class="w-16 h-1 bg-aviary-brass rounded-full shadow-[0_0_20px_#b8860b]"></div>
                        <div class="w-10 h-0.5 bg-aviary-brass/40 rounded-full"></div>
                    </div>
                    <div>
                        <p class="text-[9px] font-black text-aviary-brass uppercase tracking-[0.5em] italic mb-1">Official Registry</p>
                        <h1 class="text-4xl md:text-6xl font-industrial font-black text-white uppercase italic tracking-widest leading-none">Hall of Fame</h1>
                        <p class="text-aviary-feather/30 text-[10px] font-black uppercase tracking-[0.4em] italic mt-2">Champion Bloodlines of the Realm</p>
                    </div>
                </div>

                {{-- Filter --}}
                <div class="w-full lg:w-72">
                    <label class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest mb-2 block italic">Filter by Strain</label>
                    <div class="relative">
                        <select wire:model.live="filter"
                            class="w-full bg-aviary-oak/60 border-2 border-aviary-brass/20 rounded-2xl px-6 py-4 text-xs font-black text-aviary-brass uppercase tracking-widest focus:border-aviary-blue transition-all cursor-pointer italic appearance-none shadow-inner">
                            <option value="overall">⚡ Overall Network</option>
                            <option value="fancy">🎨 Fancy Strains</option>
                            <option value="racer">🏆 Racing Strains</option>
                            <option value="highflyer">🌤 High Flyer Strains</option>
                        </select>
                        <div class="absolute right-5 top-1/2 -translate-y-1/2 pointer-events-none text-aviary-brass/60">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- PODIUM — TOP 3 PIGEONS                                      --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    @if($topPigeons->count() >= 3)
    <div class="mb-10">
        <div class="flex items-center gap-3 mb-6 px-2">
            <span class="w-2 h-2 bg-aviary-blue rounded-full shadow-[0_0_8px_#3b82f6]"></span>
            <h2 class="text-[11px] font-black text-aviary-blue uppercase tracking-[0.4em] italic">Champion Podium — Top Specimens</h2>
        </div>

        {{-- Podium Layout: 2nd | 1st | 3rd --}}
        <div class="grid grid-cols-3 gap-4 items-end">

            {{-- 2nd Place --}}
            <div class="flex flex-col items-center gap-3">
                <div class="w-full parchment-panel rounded-[2rem] border-2 border-slate-500/30 shadow-xl overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-b from-slate-500/5 to-transparent pointer-events-none"></div>
                    <div class="p-5 text-center relative z-10">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-slate-600/40 border-2 border-slate-400/30 flex items-center justify-center shadow-lg">
                            <span class="font-industrial font-black text-3xl italic text-slate-300">2</span>
                        </div>
                        <p class="font-industrial font-black text-white uppercase tracking-wide text-sm italic truncate mb-1">{{ $topPigeons[1]->name }}</p>
                        <p class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest truncate italic mb-3">{{ $topPigeons[1]->loft->name }}</p>
                        <div class="bg-black/30 rounded-xl px-3 py-2 border border-slate-500/20">
                            <span class="block text-[8px] font-black text-aviary-feather/40 uppercase tracking-widest italic mb-0.5">Score</span>
                            <span class="font-mono font-bold text-lg text-slate-300">{{ number_format($topPigeons[1]->total_score, 1) }}</span>
                        </div>
                        <x-pigeon.registry-meta :pigeon="$topPigeons[1]" size="sm" :show-price="false" class="mt-2 justify-center" />
                    </div>
                    <div class="h-6 bg-slate-600/20 border-t border-slate-500/20 flex items-center justify-center">
                        <span class="text-[8px] font-black text-slate-400/60 uppercase tracking-widest italic">Silver</span>
                    </div>
                </div>
                <div class="w-full h-12 bg-slate-600/20 rounded-t-xl border border-slate-500/20"></div>
            </div>

            {{-- 1st Place --}}
            <div class="flex flex-col items-center gap-3">
                {{-- Crown --}}
                <div class="text-3xl animate-bounce select-none">👑</div>
                <div class="w-full parchment-panel rounded-[2rem] border-2 border-aviary-brass/50 shadow-2xl shadow-aviary-brass/20 overflow-hidden relative galvanized-border">
                    <div class="absolute inset-0 bg-gradient-to-b from-aviary-brass/10 to-transparent pointer-events-none"></div>
                    <div class="absolute top-0 left-0 right-0 h-0.5 bg-gradient-to-r from-transparent via-aviary-brass to-transparent"></div>
                    <div class="p-6 text-center relative z-10">
                        <div class="w-16 h-16 mx-auto mb-3 rounded-2xl bg-aviary-brass text-white flex items-center justify-center shadow-2xl shadow-aviary-brass/40 border-2 border-aviary-brass/60">
                            <span class="font-industrial font-black text-3xl italic">1</span>
                        </div>
                        <p class="font-industrial font-black text-white uppercase tracking-wide text-base italic truncate mb-1">{{ $topPigeons[0]->name }}</p>
                        <p class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest truncate italic mb-3">{{ $topPigeons[0]->loft->name }}</p>
                        <div class="bg-black/30 rounded-xl px-3 py-2 border border-aviary-brass/30">
                            <span class="block text-[8px] font-black text-aviary-feather/40 uppercase tracking-widest italic mb-0.5">Score</span>
                            <span class="font-mono font-bold text-2xl text-aviary-brass">{{ number_format($topPigeons[0]->total_score, 1) }}</span>
                        </div>
                        <x-pigeon.registry-meta :pigeon="$topPigeons[0]" size="sm" :show-price="false" class="mt-2 justify-center" />
                    </div>
                    <div class="h-6 bg-aviary-brass/20 border-t border-aviary-brass/30 flex items-center justify-center">
                        <span class="text-[8px] font-black text-aviary-brass/80 uppercase tracking-widest italic">Gold · Champion</span>
                    </div>
                </div>
                <div class="w-full h-20 bg-aviary-brass/10 rounded-t-xl border border-aviary-brass/20"></div>
            </div>

            {{-- 3rd Place --}}
            <div class="flex flex-col items-center gap-3">
                <div class="w-full parchment-panel rounded-[2rem] border-2 border-amber-700/30 shadow-xl overflow-hidden relative">
                    <div class="absolute inset-0 bg-gradient-to-b from-amber-800/5 to-transparent pointer-events-none"></div>
                    <div class="p-5 text-center relative z-10">
                        <div class="w-14 h-14 mx-auto mb-3 rounded-2xl bg-amber-800/40 border-2 border-amber-600/30 flex items-center justify-center shadow-lg">
                            <span class="font-industrial font-black text-3xl italic text-amber-400">3</span>
                        </div>
                        <p class="font-industrial font-black text-white uppercase tracking-wide text-sm italic truncate mb-1">{{ $topPigeons[2]->name }}</p>
                        <p class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest truncate italic mb-3">{{ $topPigeons[2]->loft->name }}</p>
                        <div class="bg-black/30 rounded-xl px-3 py-2 border border-amber-700/20">
                            <span class="block text-[8px] font-black text-aviary-feather/40 uppercase tracking-widest italic mb-0.5">Score</span>
                            <span class="font-mono font-bold text-lg text-amber-500">{{ number_format($topPigeons[2]->total_score, 1) }}</span>
                        </div>
                        <x-pigeon.registry-meta :pigeon="$topPigeons[2]" size="sm" :show-price="false" class="mt-2 justify-center" />
                    </div>
                    <div class="h-6 bg-amber-800/20 border-t border-amber-700/20 flex items-center justify-center">
                        <span class="text-[8px] font-black text-amber-600/80 uppercase tracking-widest italic">Bronze</span>
                    </div>
                </div>
                <div class="w-full h-8 bg-amber-800/10 rounded-t-xl border border-amber-700/20"></div>
            </div>

        </div>
    </div>
    @endif

    {{-- ═══════════════════════════════════════════════════════════ --}}
    {{-- MAIN TWO-COLUMN GRID                                         --}}
    {{-- ═══════════════════════════════════════════════════════════ --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        {{-- ── LEFT: Full Pigeon Rankings ──────────────────────── --}}
        <div class="space-y-4">
            <div class="flex items-center gap-3 mb-6">
                <span class="w-2 h-2 bg-aviary-blue rounded-full shadow-[0_0_8px_#3b82f6]"></span>
                <h2 class="text-[11px] font-black text-aviary-blue uppercase tracking-[0.4em] italic flex-1 border-b border-aviary-blue/20 pb-2">Top Specimens — Full Ranking</h2>
            </div>

            @foreach($topPigeons as $index => $pigeon)
                @php
                    $isFirst  = $index === 0;
                    $medal    = $index === 0 ? '🥇' : ($index === 1 ? '🥈' : ($index === 2 ? '🥉' : null));
                @endphp
                <div class="group relative flex justify-between items-center p-5 rounded-[1.8rem] transition-all duration-300 overflow-hidden border-2 shadow-lg
                    {{ $isFirst ? 'bg-aviary-brass/5 border-aviary-brass/40 shadow-aviary-brass/10' : 'bg-aviary-oak/40 border-aviary-brass/5 hover:border-aviary-blue/30 hover:bg-aviary-oak/60' }} galvanized-border">

                    @if($isFirst)
                        <div class="absolute inset-0 bg-gradient-to-r from-aviary-brass/8 to-transparent pointer-events-none"></div>
                        <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-aviary-brass/40 to-transparent"></div>
                    @endif

                    <div class="flex items-center gap-4 truncate relative z-10">
                        {{-- Rank Badge --}}
                        <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center font-industrial font-black text-xl italic
                            {{ $isFirst ? 'bg-aviary-brass text-white shadow-lg shadow-aviary-brass/40' : ($index === 1 ? 'bg-slate-600/50 text-slate-300' : ($index === 2 ? 'bg-amber-800/50 text-amber-400' : 'bg-black/30 text-aviary-feather/30 border border-aviary-brass/10')) }}">
                            {{ $index + 1 }}
                        </div>

                        <div class="truncate">
                            <div class="flex items-center gap-2 mb-0.5">
                                @if($medal)<span class="text-sm">{{ $medal }}</span>@endif
                                <p class="font-industrial font-black text-white uppercase tracking-widest text-sm md:text-base truncate italic leading-none">{{ $pigeon->name }}</p>
                            </div>
                            <div class="flex items-center gap-2 flex-wrap">
                                <p class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest italic">{{ $pigeon->loft->name }}</p>
                                <x-pigeon.registry-meta :pigeon="$pigeon" size="sm" :show-price="false" />
                            </div>
                        </div>
                    </div>

                    <div class="text-right relative z-10 flex-shrink-0 ml-4">
                        <span class="text-[8px] font-black text-aviary-feather/40 uppercase block mb-0.5 tracking-widest italic">Score</span>
                        <span class="font-mono font-bold text-lg md:text-2xl {{ $isFirst ? 'text-aviary-brass' : 'text-white/80' }} italic">{{ number_format($pigeon->total_score, 1) }}</span>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- ── RIGHT: Lofts + Value Rankings ───────────────────── --}}
        <div class="space-y-8">

            {{-- Master Breeders --}}
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <span class="w-2 h-2 bg-aviary-brass rounded-full shadow-[0_0_8px_#b8860b]"></span>
                    <h2 class="text-[11px] font-black text-aviary-brass uppercase tracking-[0.4em] italic flex-1 border-b border-aviary-brass/20 pb-2">Master Breeders — Top Lofts</h2>
                </div>

                <div class="space-y-3">
                    @foreach($topLofts as $index => $loft)
                        @php
                            $loftModel = \App\Models\Loft::where('name', $loft['name'])->first();
                            $isFirst = $index === 0;
                        @endphp
                        <div class="group relative flex justify-between items-center p-5 rounded-[1.8rem] transition-all duration-300 overflow-hidden border-2 shadow-lg
                            {{ $isFirst ? 'bg-aviary-brass/5 border-aviary-brass/40' : 'bg-aviary-oak/40 border-aviary-brass/5 hover:border-aviary-brass/30 hover:bg-aviary-oak/60' }} galvanized-border">

                            @if($isFirst)
                                <div class="absolute inset-0 bg-gradient-to-r from-aviary-brass/8 to-transparent pointer-events-none"></div>
                            @endif

                            <div class="flex items-center gap-4 truncate relative z-10">
                                <div class="flex-shrink-0 w-11 h-11 rounded-xl flex items-center justify-center font-industrial font-black text-xl italic
                                    {{ $isFirst ? 'bg-aviary-brass text-white shadow-lg shadow-aviary-brass/40' : 'bg-black/30 text-aviary-feather/30 border border-aviary-brass/10' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="truncate">
                                    @if($loftModel)
                                        <a href="{{ route('loft.view', ['loftId' => $loftModel->id]) }}"
                                           class="font-industrial font-black text-white uppercase tracking-widest text-sm md:text-base hover:text-aviary-brass transition-colors italic leading-none block truncate mb-0.5">
                                            {{ $loft['name'] }}
                                        </a>
                                    @else
                                        <p class="font-industrial font-black text-white uppercase tracking-widest text-sm md:text-base italic leading-none block truncate mb-0.5">{{ $loft['name'] }}</p>
                                    @endif
                                    <p class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest italic">Registry Grade {{ $loft['level'] }}</p>
                                </div>
                            </div>

                            <div class="text-right relative z-10 flex-shrink-0 ml-4">
                                <span class="text-[8px] font-black text-aviary-feather/40 uppercase block mb-0.5 tracking-widest italic">Prestige</span>
                                <span class="font-mono font-bold text-lg md:text-2xl {{ $isFirst ? 'text-aviary-brass' : 'text-white/80' }} italic">{{ number_format($loft['score'], 1) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Divider --}}
            <div class="flex items-center gap-4">
                <div class="flex-1 h-px bg-aviary-brass/10"></div>
                <span class="text-[8px] font-black text-aviary-brass/30 uppercase tracking-widest italic">Wealth Rankings</span>
                <div class="flex-1 h-px bg-aviary-brass/10"></div>
            </div>

            {{-- Most Expensive Pigeon --}}
            @if($mostExpensivePigeon)
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-2 h-2 bg-emerald-400 rounded-full shadow-[0_0_8px_#34d399]"></span>
                    <h2 class="text-[11px] font-black text-emerald-400 uppercase tracking-[0.4em] italic flex-1 border-b border-emerald-400/20 pb-2">Most Expensive Pigeon</h2>
                </div>
                <div class="relative p-5 rounded-[1.8rem] bg-emerald-900/10 border-2 border-emerald-500/30 shadow-xl overflow-hidden galvanized-border">
                    <div class="absolute inset-0 bg-gradient-to-r from-emerald-500/5 to-transparent pointer-events-none"></div>
                    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-emerald-400/30 to-transparent"></div>
                    <div class="flex items-center gap-4 relative z-10">
                        <div class="w-12 h-12 rounded-xl bg-emerald-500/20 border-2 border-emerald-400/30 flex items-center justify-center text-2xl flex-shrink-0">
                            💎
                        </div>
                        <div class="flex-1 truncate">
                            <p class="font-industrial font-black text-white uppercase tracking-widest text-base italic truncate">{{ $mostExpensivePigeon->name }}</p>
                            <p class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-widest italic truncate">{{ $mostExpensivePigeon->loft->name }}</p>
                            <x-pigeon.registry-meta :pigeon="$mostExpensivePigeon" size="sm" :show-price="false" class="mt-2" />
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="block text-[8px] font-black text-emerald-400/60 uppercase tracking-widest italic mb-0.5">Value</span>
                            <span class="font-mono font-bold text-xl text-emerald-400">{{ number_format($mostExpensivePigeon->fixed_price, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Most Valuable Lofts --}}
            <div>
                <div class="flex items-center gap-3 mb-4">
                    <span class="w-2 h-2 bg-aviary-blue rounded-full shadow-[0_0_8px_#3b82f6]"></span>
                    <h2 class="text-[11px] font-black text-aviary-blue uppercase tracking-[0.4em] italic flex-1 border-b border-aviary-blue/20 pb-2">Most Valuable Lofts</h2>
                </div>
                <div class="space-y-3">
                    @foreach($topValuableLofts as $index => $vLoft)
                        @php
                            $vLoftModel = \App\Models\Loft::where('name', $vLoft['name'])->first();
                            $isFirst = $index === 0;
                        @endphp
                        <div class="group relative flex justify-between items-center p-4 rounded-[1.5rem] transition-all duration-300 border overflow-hidden
                            {{ $isFirst ? 'bg-aviary-blue/5 border-aviary-blue/40 shadow-lg shadow-aviary-blue/10' : 'bg-aviary-oak/30 border-aviary-brass/5 hover:border-aviary-blue/20' }}">

                            @if($isFirst)
                                <div class="absolute inset-0 bg-gradient-to-r from-aviary-blue/5 to-transparent pointer-events-none"></div>
                            @endif

                            <div class="flex items-center gap-3 truncate relative z-10">
                                <div class="flex-shrink-0 w-9 h-9 rounded-xl flex items-center justify-center font-industrial font-black text-base italic
                                    {{ $isFirst ? 'bg-aviary-blue text-white shadow-lg' : 'bg-black/30 text-aviary-feather/30 border border-aviary-brass/10' }}">
                                    {{ $index + 1 }}
                                </div>
                                <div class="truncate">
                                    @if($vLoftModel)
                                        <a href="{{ route('loft.view', ['loftId' => $vLoftModel->id]) }}"
                                           class="font-industrial font-black text-white uppercase tracking-widest text-sm hover:text-aviary-blue transition-colors italic block truncate">
                                            {{ $vLoft['name'] }}
                                        </a>
                                    @else
                                        <p class="font-industrial font-black text-white uppercase tracking-widest text-sm italic truncate">{{ $vLoft['name'] }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="text-right flex-shrink-0 ml-3 relative z-10">
                                <span class="block text-[8px] font-black text-aviary-feather/40 uppercase tracking-widest italic mb-0.5">Value</span>
                                <span class="font-mono font-bold text-base {{ $isFirst ? 'text-aviary-blue' : 'text-white/70' }}">{{ number_format($vLoft['value'], 2) }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>

</div>
