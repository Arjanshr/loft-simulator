<div class="marketplace-shell marketplace-noise relative overflow-hidden font-sans text-slate-300">
    @php
        $listingCount = $listings->count();
        $avgPrice = $listingCount ? (int) round($listings->avg('price')) : 0;
        $topPrice = $listingCount ? (int) $listings->max('price') : 0;
        $featuredListing = $listings->first();
        $activeFilters = collect([$search, $type, $gender, $minPrice, $maxPrice])->filter(fn ($value) => filled($value))->count();
    @endphp

    <!-- Notifications -->
    <div class="fixed top-20 right-4 z-50 flex flex-col gap-2">
        @if (session()->has('message'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                 class="rounded-2xl border border-aviary-blue/30 bg-aviary-blue/90 px-6 py-3 font-industrial italic text-white shadow-2xl">
                {{ session('message') }}
            </div>
        @endif
        @if (session()->has('error'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show"
                 class="rounded-2xl border border-red-500/30 bg-red-950/90 px-6 py-3 font-industrial italic text-white shadow-2xl">
                {{ session('error') }}
            </div>
        @endif
    </div>

    <div class="relative isolate">
        <div class="absolute inset-x-0 top-0 h-72 bg-gradient-to-b from-aviary-blue/15 via-transparent to-transparent pointer-events-none"></div>
        <div class="absolute -top-10 left-10 h-56 w-56 rounded-full bg-aviary-brass/10 blur-3xl pointer-events-none"></div>
        <div class="absolute top-24 right-12 h-72 w-72 rounded-full bg-aviary-blue/10 blur-3xl pointer-events-none"></div>

        <div class="relative mx-auto max-w-7xl px-4 py-6 md:px-8 md:py-10">
            <!-- Hero -->
            <section class="overflow-hidden rounded-[2.75rem] border border-white/10 bg-black/35 shadow-[0_25px_100px_rgba(0,0,0,0.45)] backdrop-blur-xl">
                <div class="grid gap-8 xl:grid-cols-[1.25fr_0.75fr]">
                    <div class="relative p-8 md:p-12">
                        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(184,134,11,0.12),transparent_40%),radial-gradient(circle_at_bottom_right,rgba(59,130,246,0.14),transparent_42%)] pointer-events-none"></div>
                        <div class="relative z-10">
                            <div class="inline-flex items-center gap-3 rounded-full border border-aviary-brass/20 bg-white/5 px-4 py-2 text-[9px] font-black uppercase tracking-[0.35em] text-aviary-brass italic">
                                The Exchange
                                <span class="h-1.5 w-1.5 rounded-full bg-aviary-blue shadow-[0_0_12px_#3b82f6]"></span>
                            </div>

                            <div class="mt-6 flex flex-col gap-5">
                                <div>
                                    <h1 class="max-w-4xl text-4xl font-industrial font-black uppercase italic leading-[0.9] tracking-tighter text-white md:text-6xl">
                                        Market birds like museum pieces, not commodity scraps.
                                    </h1>
                                    <p class="mt-4 max-w-2xl text-sm font-bold uppercase italic tracking-[0.2em] text-aviary-feather/45 md:text-[11px]">
                                        Every listing is locked to fixed value, derived from rarity and attributes, with no manual price drift across the market.
                                    </p>
                                </div>

                                <div class="flex flex-wrap gap-3">
                                    <div class="rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
                                        <span class="block text-[8px] font-black uppercase tracking-[0.35em] text-aviary-feather/35">Active</span>
                                        <span class="mt-1 block font-mono text-xl font-bold text-white">{{ $listingCount }}</span>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
                                        <span class="block text-[8px] font-black uppercase tracking-[0.35em] text-aviary-feather/35">Average</span>
                                        <span class="mt-1 block font-mono text-xl font-bold text-aviary-brass">{{ number_format($avgPrice) }}</span>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
                                        <span class="block text-[8px] font-black uppercase tracking-[0.35em] text-aviary-feather/35">Top Value</span>
                                        <span class="mt-1 block font-mono text-xl font-bold text-emerald-400">{{ number_format($topPrice) }}</span>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
                                        <span class="block text-[8px] font-black uppercase tracking-[0.35em] text-aviary-feather/35">Filters</span>
                                        <span class="mt-1 block font-mono text-xl font-bold text-sky-300">{{ $activeFilters }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex items-stretch border-t border-white/10 xl:border-l xl:border-t-0">
                        <div class="flex w-full flex-col justify-between gap-6 p-8 md:p-12">
                            <div class="rounded-[2rem] border border-aviary-brass/20 bg-gradient-to-br from-aviary-brass/10 via-black/40 to-aviary-blue/10 p-6 shadow-inner">
                                <span class="text-[9px] font-black uppercase tracking-[0.35em] text-aviary-brass italic">Market Rule</span>
                                <p class="mt-3 text-sm font-bold uppercase italic tracking-[0.18em] text-white/85">
                                    Fixed price is enforced everywhere, based on the pigeon's computed value.
                                </p>
                                <div class="mt-5 flex items-center justify-between rounded-2xl border border-white/10 bg-black/30 px-4 py-3">
                                    <span class="text-[8px] font-black uppercase tracking-[0.3em] text-aviary-feather/35">Currently listed</span>
                                    <span class="font-mono text-lg font-bold text-white">{{ number_format($listingCount) }}</span>
                                </div>
                            </div>

                            <div class="rounded-[2rem] border border-white/10 bg-white/5 p-6">
                                <div class="flex items-center gap-3">
                                    <div class="h-10 w-10 rounded-2xl bg-aviary-blue/20 text-aviary-blue flex items-center justify-center">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 7h18M5 7l1 13h12l1-13M10 11v6m4-6v6M9 7V4h6v3" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-aviary-feather/40 italic">New listings</p>
                                        <p class="text-sm font-bold text-white">Always stored at the bird's fixed price.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <div class="mt-8 grid gap-8 xl:grid-cols-[20rem_minmax(0,1fr)]">
                <!-- Sidebar -->
                <aside class="xl:sticky xl:top-8 xl:self-start">
                    <div class="rounded-[2.5rem] border border-white/10 bg-black/45 p-6 shadow-[0_20px_80px_rgba(0,0,0,0.35)] backdrop-blur-xl">
                        <div class="flex items-center justify-between border-b border-white/10 pb-4">
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-[0.35em] text-aviary-brass italic">Filters</p>
                                <h2 class="mt-1 text-2xl font-industrial font-black uppercase italic tracking-tight text-white">Refine the feed</h2>
                            </div>
                            @if($activeFilters > 0)
                                <button type="button" wire:click="clearFilters"
                                        class="rounded-full border border-aviary-brass/20 bg-aviary-brass/10 px-3 py-2 text-[9px] font-black uppercase tracking-[0.2em] text-aviary-brass">
                                    Reset
                                </button>
                            @endif
                        </div>

                        <div class="mt-6 space-y-6">
                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-aviary-feather/55 italic">Search registry</label>
                                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Search bird name..."
                                       class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 font-mono text-sm text-white placeholder:text-white/30 focus:border-aviary-blue focus:outline-none">
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-aviary-feather/55 italic">Strain</label>
                                <select wire:model.live="type"
                                        class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 font-black uppercase tracking-widest text-white focus:border-aviary-blue focus:outline-none">
                                    <option value="">All strains</option>
                                    <option value="racer">Racer</option>
                                    <option value="fancy">Fancy</option>
                                    <option value="highflyer">Highflyer</option>
                                </select>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-aviary-feather/55 italic">Gender</label>
                                <div class="grid grid-cols-3 gap-2">
                                    @foreach(['' => 'All', 'male' => 'Cock', 'female' => 'Hen'] as $val => $label)
                                        <button type="button" wire:click="$set('gender', '{{ $val }}')"
                                                class="rounded-2xl border px-3 py-3 text-[9px] font-black uppercase tracking-widest transition
                                                {{ $gender === $val ? 'border-aviary-blue bg-aviary-blue text-white shadow-[0_0_20px_rgba(59,130,246,0.25)]' : 'border-white/10 bg-white/5 text-aviary-feather/55 hover:border-aviary-brass/30' }}">
                                            {{ $label }}
                                        </button>
                                    @endforeach
                                </div>
                            </div>

                            <div class="space-y-3">
                                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-aviary-feather/55 italic">Price range</label>
                                <div class="grid grid-cols-2 gap-3">
                                    <input wire:model.live="minPrice" type="number" placeholder="Min"
                                           class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 font-mono text-sm text-white placeholder:text-white/30 focus:border-aviary-blue focus:outline-none">
                                    <input wire:model.live="maxPrice" type="number" placeholder="Max"
                                           class="w-full rounded-2xl border border-white/10 bg-white/5 px-4 py-4 font-mono text-sm text-white placeholder:text-white/30 focus:border-aviary-blue focus:outline-none">
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- Main content -->
                <main class="space-y-8">
                    <!-- Featured listing -->
                    @if($featuredListing)
                        @php
                            $remainingSecs = now()->diffInSeconds($featuredListing->expires_at, false);
                            $isExpired = $remainingSecs <= 0;
                        @endphp
                        <section class="overflow-hidden rounded-[2.5rem] border border-aviary-brass/20 bg-black/35 shadow-[0_20px_70px_rgba(0,0,0,0.35)] backdrop-blur-xl">
                            <div class="relative overflow-hidden">
                                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,rgba(184,134,11,0.14),transparent_38%),radial-gradient(circle_at_right,rgba(59,130,246,0.12),transparent_42%)] pointer-events-none"></div>
                                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-transparent via-aviary-brass to-transparent"></div>

                                <div class="relative z-10 grid gap-0 lg:grid-cols-[minmax(0,1.45fr)_22rem]">
                                    <div class="p-7 md:p-10">
                                        <div class="flex flex-col gap-6 sm:flex-row sm:items-start sm:justify-between sm:gap-4">
                                            <div class="flex min-w-0 flex-col gap-4 sm:flex-row sm:items-start">
                                                <span class="w-fit mt-1 rounded-full border border-aviary-brass/20 bg-aviary-brass/10 px-3 py-1 text-[9px] font-black uppercase tracking-[0.3em] text-aviary-brass italic">
                                                    Featured
                                                </span>
                                                <div class="min-w-0">
                                                    <div class="flex flex-wrap items-center gap-3">
                                                        <span class="rounded-xl bg-aviary-blue px-3 py-1 text-[9px] font-black uppercase italic text-white shadow-lg">
                                                            LV.{{ $featuredListing->pigeon->level }}
                                                        </span>
                                                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-aviary-feather/40 italic">
                                                            {{ $featuredListing->pigeon->type }} strain
                                                        </p>
                                                    </div>
                                                    <h3 class="mt-3 truncate text-3xl font-industrial font-black uppercase italic leading-none tracking-tighter text-white md:text-5xl">
                                                        {{ $featuredListing->pigeon->name }}
                                                    </h3>
                                                </div>
                                            </div>

                                            <div class="w-full sm:w-auto rounded-2xl border border-white/10 bg-black/30 px-4 py-3 sm:text-right">
                                                <span class="block text-[8px] font-black uppercase tracking-[0.3em] text-aviary-feather/35 italic">Fixed price</span>
                                                <span class="mt-1 block font-industrial text-3xl font-black italic text-aviary-brass md:text-4xl">
                                                    {{ number_format($featuredListing->price) }}
                                                </span>
                                            </div>
                                        </div>

                                        <p class="mt-4 max-w-2xl text-sm font-bold uppercase italic tracking-[0.2em] text-aviary-feather/45">
                                            A curated specimen with a locked market value and a fully visible stat profile.
                                        </p>

                                        <div class="mt-6">
                                            <x-pigeon.registry-meta :pigeon="$featuredListing->pigeon" size="sm" :show-price="false" class="justify-start" />
                                        </div>

                                        <div class="mt-7 grid gap-3 sm:grid-cols-2 xl:grid-cols-4">
                                            @foreach(['speed' => 'SPD', 'endurance' => 'END', 'navigation' => 'NAV', 'temperament' => 'TMP'] as $stat => $abbr)
                                                <div class="rounded-2xl border border-white/10 bg-white/5 px-4 py-4">
                                                    <div class="flex items-center justify-between">
                                                        <span class="text-[8px] font-black uppercase tracking-[0.25em] text-aviary-feather/40 italic">{{ $abbr }}</span>
                                                        <span class="font-mono text-sm font-bold text-white">{{ $featuredListing->pigeon->$stat }}</span>
                                                    </div>
                                                    <div class="mt-3 h-1.5 overflow-hidden rounded-full bg-black/50">
                                                        <div class="h-full rounded-full bg-gradient-to-r from-aviary-brass to-amber-200"
                                                             style="width: {{ min(100, ($featuredListing->pigeon->$stat / ($featuredListing->pigeon->level * $featuredListing->pigeon->stat_limit_multiplier ?: 10)) * 100) }}%"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="border-t border-white/10 bg-black/20 p-7 md:p-8 lg:border-l lg:border-t-0">
                                        <div class="flex h-full flex-col justify-between gap-6">
                                            <div class="rounded-[2rem] border border-white/10 bg-white/5 p-5">
                                                <div class="flex items-center justify-between">
                                                    <span class="text-[9px] font-black uppercase tracking-[0.3em] text-aviary-feather/40 italic">Market cert</span>
                                                    <span class="text-[8px] font-black uppercase tracking-[0.3em] text-aviary-blue italic">Verified</span>
                                                </div>
                                                <div class="mt-5 grid grid-cols-2 gap-3 text-[9px] font-black uppercase tracking-[0.25em] text-aviary-feather/50">
                                                    <div class="rounded-2xl border border-white/10 bg-black/30 px-3 py-3">
                                                        <span class="block text-aviary-feather/35">Gender</span>
                                                        <span class="mt-1 block text-white">{{ $featuredListing->pigeon->gender == 'male' ? '♂ Cock' : '♀ Hen' }}</span>
                                                    </div>
                                                    <div class="rounded-2xl border border-white/10 bg-black/30 px-3 py-3">
                                                        <span class="block text-aviary-feather/35">Beauty</span>
                                                        <span class="mt-1 block text-white">{{ $featuredListing->pigeon->stat_grades['beauty'] }} pts</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="rounded-[2rem] border border-aviary-brass/20 bg-gradient-to-br from-aviary-brass/15 to-black/30 p-5">
                                                <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                                                    <div>
                                                        <span class="block text-[8px] font-black uppercase tracking-[0.3em] text-aviary-feather/40 italic">Auction timer</span>
                                                        <span class="mt-1 block font-mono text-xl font-bold text-white">{{ $isExpired ? '00:00:00' : gmdate('H:i:s', $remainingSecs) }}</span>
                                                    </div>
                                                    <span class="w-fit rounded-full border border-aviary-brass/20 bg-black/30 px-3 py-2 text-[9px] font-black uppercase tracking-[0.25em] text-aviary-brass italic">
                                                        {{ $isExpired ? 'Expired' : 'Live' }}
                                                    </span>
                                                </div>
                                                <button wire:click="buy({{ $featuredListing->id }})"
                                                        @if($isExpired) disabled @endif
                                                        class="mt-5 w-full rounded-2xl px-5 py-4 font-industrial text-sm font-black uppercase italic tracking-[0.2em] transition
                                                        {{ $isExpired ? 'cursor-not-allowed border border-white/10 bg-white/5 text-white/25' : 'border border-white/10 bg-aviary-brass text-white hover:bg-aviary-blue' }}">
                                                    Purchase specimen
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    @endif

                    <!-- Listings grid -->
                    <section>
                        <div class="mb-5 flex items-center justify-between">
                            <div>
                                <p class="text-[9px] font-black uppercase tracking-[0.3em] text-aviary-blue italic">Available birds</p>
                                <h2 class="mt-1 text-2xl font-industrial font-black uppercase italic tracking-tight text-white md:text-3xl">Registry wall</h2>
                            </div>
                            <p class="text-[9px] font-black uppercase tracking-[0.25em] text-aviary-feather/40 italic">
                                {{ $listingCount }} results
                            </p>
                        </div>

                        @if($listingCount > 1)
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 2xl:grid-cols-3">
                                @foreach($listings->skip(1) as $listing)
                                    <article class="group relative overflow-hidden rounded-[2.25rem] border border-white/10 bg-black/35 shadow-[0_18px_60px_rgba(0,0,0,0.35)] transition-transform duration-300 hover:-translate-y-1">
                                        <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-aviary-brass via-aviary-blue to-emerald-400"></div>
                                        <div class="absolute -right-16 top-4 h-32 w-32 rounded-full bg-aviary-brass/10 blur-3xl transition-opacity group-hover:opacity-70"></div>

                                        <div class="relative flex h-full flex-col p-6 md:p-7">
                                            <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                                <div class="min-w-0">
                                                    <div class="flex flex-wrap items-center gap-2">
                                                        <span class="rounded-xl bg-aviary-blue px-2.5 py-1 text-[9px] font-black italic uppercase text-white">
                                                            LV.{{ $listing->pigeon->level }}
                                                        </span>
                                                        <span class="text-[9px] font-black uppercase tracking-[0.25em] text-aviary-feather/35 italic">
                                                            {{ strtoupper($listing->pigeon->type) }}
                                                        </span>
                                                    </div>
                                                    <h3 class="mt-4 truncate text-2xl font-industrial font-black uppercase italic leading-none tracking-tighter text-white">
                                                        {{ $listing->pigeon->name }}
                                                    </h3>
                                                </div>

                                                <div class="w-full sm:w-auto rounded-2xl border border-aviary-brass/20 bg-aviary-brass/10 px-4 py-3 sm:text-right">
                                                    <span class="block text-[8px] font-black uppercase tracking-[0.3em] text-aviary-feather/35 italic">Fixed</span>
                                                    <span class="mt-1 block font-mono text-lg font-bold text-aviary-brass">{{ number_format($listing->price) }}</span>
                                                </div>
                                            </div>

                                            <div class="mt-6">
                                                <x-pigeon.registry-meta :pigeon="$listing->pigeon" size="sm" class="justify-start" />
                                            </div>

                                            <div class="mt-6 grid grid-cols-2 gap-3 font-mono">
                                                @foreach(['speed' => 'SPD', 'endurance' => 'END', 'navigation' => 'NAV', 'temperament' => 'TMP', 'intelligence' => 'INT'] as $stat => $abbr)
                                                    <div class="rounded-2xl border border-white/10 bg-white/5 px-3 py-3">
                                                        <div class="flex items-center justify-between text-[8px] font-black uppercase tracking-[0.25em] text-aviary-feather/35">
                                                            <span>{{ $abbr }}</span>
                                                            <span class="text-white">{{ $listing->pigeon->$stat }}</span>
                                                        </div>
                                                        <div class="mt-2 h-1.5 overflow-hidden rounded-full bg-black/50">
                                                            <div class="h-full rounded-full {{ $stat === 'intelligence' ? 'bg-aviary-blue' : 'bg-aviary-brass' }}"
                                                                 style="width: {{ ($listing->pigeon->$stat / ($stat === 'intelligence' ? 100 : ($listing->pigeon->level * $listing->pigeon->stat_limit_multiplier ?: 10))) * 100 }}%"></div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="mt-6 grid grid-cols-2 gap-3 text-[9px] font-black uppercase tracking-[0.25em] text-aviary-feather/50">
                                                <div class="rounded-2xl border border-white/10 bg-white/5 px-3 py-3">
                                                    <span class="block text-aviary-feather/35">Gender</span>
                                                    <span class="mt-1 block {{ $listing->pigeon->gender == 'male' ? 'text-aviary-blue' : 'text-aviary-rose' }}">
                                                        {{ $listing->pigeon->gender == 'male' ? '♂ Cock' : '♀ Hen' }}
                                                    </span>
                                                </div>
                                                <div class="rounded-2xl border border-white/10 bg-white/5 px-3 py-3">
                                                    <span class="block text-aviary-feather/35">Beauty</span>
                                                    <span class="mt-1 block text-white">{{ $listing->pigeon->stat_grades['beauty'] }} pts</span>
                                                </div>
                                            </div>

                                            <div class="mt-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-t border-white/10 pt-5">
                                                @php
                                                    $remainingSecs = now()->diffInSeconds($listing->expires_at, false);
                                                    $isExpired = $remainingSecs <= 0;
                                                @endphp
                                                <div>
                                                    <span class="block text-[8px] font-black uppercase tracking-[0.25em] text-aviary-feather/35 italic">Expires in</span>
                                                    <span class="mt-1 block font-mono text-sm font-bold text-white">{{ $isExpired ? '00:00:00' : gmdate('H:i:s', $remainingSecs) }}</span>
                                                </div>
                                                <button wire:click="buy({{ $listing->id }})"
                                                        @if($isExpired) disabled @endif
                                                        class="w-full sm:w-auto rounded-2xl px-4 py-3 text-[9px] font-black uppercase tracking-[0.22em] transition
                                                        {{ $isExpired ? 'cursor-not-allowed border border-white/10 bg-white/5 text-white/25' : 'border border-white/10 bg-aviary-brass text-white hover:bg-aviary-blue' }}">
                                                    Buy
                                                </button>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            </div>
                        @endif

                        @if($listings->isEmpty())
                            <div class="mt-8 rounded-[3rem] border border-dashed border-white/10 bg-black/25 px-8 py-20 text-center">
                                <div class="mx-auto mb-6 flex h-16 w-16 items-center justify-center rounded-full border border-aviary-brass/20 bg-aviary-brass/10 text-3xl">
                                    🕊
                                </div>
                                <h3 class="text-2xl font-industrial font-black uppercase italic tracking-tight text-white">
                                    No specimens match the current registry
                                </h3>
                                <p class="mx-auto mt-3 max-w-xl text-sm font-bold uppercase italic tracking-[0.2em] text-aviary-feather/40">
                                    Adjust your filters or wait for a new listing to land in the exchange.
                                </p>
                            </div>
                        @endif
                    </section>
                </main>
            </div>
        </div>
    </div>
</div>
