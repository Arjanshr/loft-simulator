<div class="relative space-y-10 font-sans text-slate-300">
    @php
        $settingMeta = [
            'breeding_cost' => [
                'title' => 'Breeding Cost',
                'description' => 'Coins required to start a breeding pair.',
                'dot' => 'bg-aviary-brass shadow-[0_0_12px_rgba(184,134,11,0.55)]',
            ],
            'training_energy_cost' => [
                'title' => 'Training Energy Cost',
                'description' => 'Energy removed when a bird trains.',
                'dot' => 'bg-aviary-blue shadow-[0_0_12px_rgba(59,130,246,0.55)]',
            ],
            'aesthetic_upgrade_base_cost' => [
                'title' => 'Aesthetic Upgrade Base Cost',
                'description' => 'Base coins for appearance upgrades.',
                'dot' => 'bg-emerald-400 shadow-[0_0_12px_rgba(74,222,128,0.55)]',
            ],
            'ai_lost_birds_per_human_per_hour' => [
                'title' => 'AI Loss Rate',
                'description' => 'Average birds lost per human player each hour.',
                'dot' => 'bg-purple-400 shadow-[0_0_12px_rgba(192,132,252,0.55)]',
            ],
        ];
    @endphp

    <div class="fixed top-20 right-4 z-50 flex flex-col gap-2">
        @if (session()->has('message'))
            <div
                x-data="{ show: true }"
                x-init="setTimeout(() => show = false, 3000)"
                x-show="show"
                class="rounded-2xl border border-white/10 bg-aviary-blue px-5 py-3 text-white shadow-2xl shadow-aviary-blue/20"
            >
                <p class="text-[10px] font-black uppercase tracking-[0.35em] italic">System update</p>
                <p class="mt-1 text-sm font-semibold">{{ session('message') }}</p>
            </div>
        @endif
    </div>

    <section class="relative overflow-hidden rounded-[3rem] border border-white/10 bg-[linear-gradient(180deg,rgba(15,23,42,0.96),rgba(2,6,23,0.98))] p-6 shadow-[0_30px_120px_rgba(0,0,0,0.45)] md:p-10">
        <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top_left,rgba(184,134,11,0.12),transparent_28%),radial-gradient(circle_at_top_right,rgba(59,130,246,0.12),transparent_26%),linear-gradient(135deg,rgba(255,255,255,0.04),transparent_40%,rgba(184,134,11,0.06))]"></div>
        <div class="absolute -right-10 top-0 select-none text-[7rem] font-industrial font-black uppercase italic tracking-tight text-white/5 md:text-[10rem]">
            Control
        </div>

        <div class="relative z-10 space-y-10">
            <div class="flex flex-col gap-8 border-b border-white/10 pb-8 md:flex-row md:items-end md:justify-between">
                <div class="max-w-3xl space-y-4">
                    <div class="flex items-center gap-4">
                        <div class="h-1.5 w-14 rounded-full bg-aviary-brass shadow-[0_0_14px_rgba(184,134,11,0.5)]"></div>
                        <span class="text-[10px] font-black uppercase tracking-[0.35em] text-aviary-brass">Policy Desk</span>
                    </div>
                    <div class="space-y-2">
                        <h2 class="text-4xl font-industrial font-black uppercase italic leading-none text-white md:text-6xl">
                            Administrative control room
                        </h2>
                        <p class="max-w-2xl text-sm leading-relaxed text-slate-300/75 md:text-base">
                            Adjust game rules, trigger world events, and inspect AI lofts from a single command surface.
                        </p>
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-3 md:min-w-[420px]">
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">AI lofts</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ number_format($aiLofts->count()) }}</p>
                    </div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Specimens</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ number_format($totalAiSpecimens) }}</p>
                    </div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">AI wealth</p>
                        <p class="mt-2 text-2xl font-black text-white">{{ number_format($totalAiCoins) }}💰</p>
                    </div>
                    <div class="rounded-[1.75rem] border border-white/10 bg-white/5 p-4 backdrop-blur">
                        <p class="text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Live mode</p>
                        <p class="mt-2 text-2xl font-black text-aviary-brass">Online</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 xl:grid-cols-[1.1fr_0.9fr]">
                <section class="rounded-[2.75rem] border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur md:p-8">
                    <div class="flex flex-col gap-4 border-b border-white/10 pb-6 md:flex-row md:items-end md:justify-between">
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-[0.35em] text-aviary-brass">Registry Parameters</p>
                            <h3 class="mt-2 text-2xl font-black italic uppercase text-white">Game settings</h3>
                        </div>
                        <p class="max-w-xl text-sm text-slate-300/70">
                            These values update the live ruleset immediately after you save them.
                        </p>
                    </div>

                    <form wire:submit="updateSettings" class="mt-6 space-y-6">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                            @foreach($settings as $key => $value)
                                @php
                                    $meta = $settingMeta[$key] ?? [
                                        'title' => str_replace('_', ' ', $key),
                                        'description' => 'Custom rule setting.',
                                        'accent' => 'white',
                                    ];
                                @endphp

                                <div class="group rounded-[1.75rem] border border-white/10 bg-black/20 p-5 shadow-inner transition-all hover:border-white/20">
                                    <div class="mb-4 flex items-start justify-between gap-4">
                                        <div>
                                            <p class="text-sm font-black uppercase italic tracking-[0.2em] text-white">{{ $meta['title'] }}</p>
                                            <p class="mt-2 text-xs leading-relaxed text-slate-400">{{ $meta['description'] }}</p>
                                        </div>
                                        <div class="h-3 w-3 rounded-full {{ $meta['dot'] }}"></div>
                                    </div>

                                    <label class="mb-2 block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Value</label>
                                    <input
                                        wire:model="settings.{{ $key }}"
                                        type="number"
                                        step="{{ $key === 'ai_lost_birds_per_human_per_hour' ? '0.1' : '1' }}"
                                        min="0"
                                        class="w-full rounded-2xl border border-white/10 bg-aviary-oak/70 p-4 font-mono text-sm text-white shadow-inner outline-none transition focus:border-aviary-blue focus:ring-0"
                                    >
                                </div>
                            @endforeach
                        </div>

                        <button
                            type="submit"
                            class="group inline-flex w-full items-center justify-center rounded-[1.75rem] border border-white/10 bg-aviary-brass px-6 py-4 text-sm font-black uppercase italic tracking-[0.25em] text-white shadow-2xl transition-all hover:bg-aviary-blue"
                        >
                            <span class="transition-transform group-hover:scale-[1.02]">Save Protocols</span>
                        </button>
                    </form>
                </section>

                <aside class="space-y-6">
                    <section class="overflow-hidden rounded-[2.75rem] border border-white/10 bg-[linear-gradient(180deg,rgba(19,24,35,0.95),rgba(12,16,26,0.95))] p-6 shadow-2xl md:p-8">
                        <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-5">
                            <div>
                                <p class="text-[10px] font-black uppercase tracking-[0.35em] text-aviary-blue">Registry Tick</p>
                                <h3 class="mt-2 text-2xl font-black italic uppercase text-white">World actions</h3>
                            </div>
                            <div class="flex h-16 w-16 items-center justify-center rounded-full border border-aviary-brass/20 bg-white/5">
                                <svg class="h-8 w-8 animate-spin-slow text-aviary-brass drop-shadow-[0_0_8px_rgba(184,134,11,0.5)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>

                        <p class="mt-5 text-sm leading-relaxed text-slate-300/70">
                            Trigger background world systems manually when you want to accelerate the simulation.
                        </p>

                        <div class="mt-6 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <button wire:click="runMaturation" class="rounded-2xl border border-white/10 bg-white px-5 py-4 text-xs font-black uppercase italic tracking-[0.2em] text-black transition hover:bg-aviary-brass hover:text-white">
                                Hatch & Mature
                            </button>
                            <button wire:click="runMarketTick" class="rounded-2xl border border-white/10 bg-aviary-brass px-5 py-4 text-xs font-black uppercase italic tracking-[0.2em] text-white transition hover:bg-aviary-blue">
                                Update Market
                            </button>
                            <button wire:click="runPassiveIncome" class="rounded-2xl border border-aviary-blue/20 bg-aviary-blue/10 px-5 py-4 text-xs font-black uppercase italic tracking-[0.2em] text-aviary-blue transition hover:bg-aviary-blue hover:text-white sm:col-span-2">
                                Distribute Reserve Funds
                            </button>
                            <button wire:click="runEnergyRecovery" class="rounded-2xl border border-white/10 bg-white/5 px-5 py-4 text-xs font-black uppercase italic tracking-[0.2em] text-slate-200 transition hover:bg-aviary-blue hover:text-white sm:col-span-2">
                                Restore Condition Rings
                            </button>
                            <button wire:click="runProcessLostBirds" class="rounded-2xl border border-purple-500/20 bg-purple-950/30 px-5 py-4 text-xs font-black uppercase italic tracking-[0.2em] text-purple-300 transition hover:bg-purple-900 hover:text-white sm:col-span-2">
                                Process Stray Sightings
                            </button>
                        </div>
                    </section>

                    <section class="rounded-[2.75rem] border border-aviary-brass/10 bg-white/5 p-6 shadow-2xl md:p-8">
                        <p class="text-[10px] font-black uppercase tracking-[0.35em] text-aviary-brass">Current Focus</p>
                        <h3 class="mt-2 text-2xl font-black italic uppercase text-white">Selected AI loft</h3>

                        @if($selectedAiLoft)
                            <div class="mt-5 rounded-[2rem] border border-white/10 bg-black/20 p-5">
                                <p class="text-lg font-black italic uppercase text-white">{{ $selectedAiLoft->name }}</p>
                                <div class="mt-4 grid grid-cols-2 gap-3 text-xs font-black uppercase tracking-[0.2em] text-slate-400">
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                        <span class="block text-[9px]">Level</span>
                                        <span class="mt-2 block text-base text-white">{{ $selectedAiLoft->level }}</span>
                                    </div>
                                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                                        <span class="block text-[9px]">Birds</span>
                                        <span class="mt-2 block text-base text-white">{{ $selectedAiLoft->pigeons->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-5 rounded-[2rem] border border-dashed border-white/10 bg-black/20 p-6 text-center">
                                <p class="text-sm font-semibold text-slate-400">Select an AI loft below to inspect its birds and activity logs.</p>
                            </div>
                        @endif
                    </section>
                </aside>
            </div>

            {{-- Tournament Configuration Section --}}
            <section class="rounded-[2.75rem] border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur md:p-8">
                <div class="flex flex-col gap-4 border-b border-white/10 pb-6 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.35em] text-purple-400">Flight Registry</p>
                        <h3 class="mt-2 text-2xl font-black italic uppercase text-white">Tournament configuration</h3>
                    </div>
                    <p class="max-w-xl text-sm text-slate-300/70">
                        Create, edit, and remove tournaments. Entry fees are charged in tokens. Prize pools are paid in the race-type currency.
                    </p>
                </div>

                {{-- Race List Table --}}
                <div class="mt-6 overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-300">
                        <thead>
                            <tr class="border-b border-white/10 text-[10px] font-black uppercase tracking-[0.25em] text-slate-400">
                                <th class="px-4 py-3">Title</th>
                                <th class="px-4 py-3">Type</th>
                                <th class="px-4 py-3">Distance</th>
                                <th class="px-4 py-3">Tier</th>
                                <th class="px-4 py-3">Entry 🎟️</th>
                                <th class="px-4 py-3">Prize Pool</th>
                                <th class="px-4 py-3">Min Level</th>
                                <th class="px-4 py-3 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($races as $race)
                                <tr class="border-b border-white/5 transition hover:bg-white/5">
                                    <td class="px-4 py-3 font-black text-white">{{ $race['title'] }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-block rounded-full border px-3 py-1 text-[10px] font-black uppercase tracking-widest
                                            {{ $race['race_type'] === 'exhibition' ? 'border-emerald-500/20 bg-emerald-900/20 text-emerald-400' : '' }}
                                            {{ $race['race_type'] === 'highflyer' ? 'border-purple-500/20 bg-purple-900/20 text-purple-400' : '' }}
                                            {{ $race['race_type'] === 'racing' ? 'border-aviary-blue/20 bg-aviary-blue/10 text-aviary-blue' : '' }}
                                        ">{{ $race['race_type'] }}</span>
                                    </td>
                                    <td class="px-4 py-3 font-mono">{{ $race['distance_km'] }}km</td>
                                    <td class="px-4 py-3 font-mono">{{ $race['difficulty_tier'] }}</td>
                                    <td class="px-4 py-3 font-mono text-purple-300">{{ number_format($race['entry_fee']) }}</td>
                                    <td class="px-4 py-3 font-mono text-aviary-brass">{{ number_format($race['prize_pool']) }}</td>
                                    <td class="px-4 py-3 font-mono">Lv.{{ $race['level_requirement'] }}</td>
                                    <td class="px-4 py-3 text-right">
                                        <button wire:click="editRace({{ $race['id'] }})" class="mr-2 rounded-lg border border-aviary-blue/20 bg-aviary-blue/10 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-aviary-blue transition hover:bg-aviary-blue hover:text-white">
                                            Edit
                                        </button>
                                        <button wire:click="deleteRace({{ $race['id'] }})" wire:confirm="Delete this tournament?" class="rounded-lg border border-red-500/20 bg-red-950/30 px-3 py-1.5 text-[10px] font-black uppercase tracking-widest text-red-400 transition hover:bg-red-600 hover:text-white">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-8 text-center italic text-slate-500">No tournaments configured yet.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Create / Edit Race Form --}}
                <div class="mt-8 rounded-[2rem] border border-white/10 bg-black/20 p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h4 class="text-lg font-black italic uppercase text-white">
                            {{ $editingRaceId ? 'Edit Tournament' : 'Create New Tournament' }}
                        </h4>
                        @if($editingRaceId)
                            <button wire:click="cancelRaceEdit" class="rounded-lg border border-white/10 bg-white/5 px-4 py-2 text-[10px] font-black uppercase tracking-widest text-slate-400 transition hover:bg-white/10">
                                Cancel
                            </button>
                        @endif
                    </div>

                    <form wire:submit="saveRace" class="space-y-5">
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                            {{-- Title --}}
                            <div class="sm:col-span-2">
                                <label class="mb-1 block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Tournament Title</label>
                                <input wire:model="raceForm.title" type="text" placeholder="e.g. Grand Championship"
                                    class="w-full rounded-xl border border-white/10 bg-aviary-oak/70 p-3 font-mono text-sm text-white outline-none transition focus:border-purple-400 focus:ring-0">
                                @error('raceForm.title') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>

                            {{-- Race Type --}}
                            <div>
                                <label class="mb-1 block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Race Type</label>
                                <select wire:model="raceForm.race_type"
                                    class="w-full rounded-xl border border-white/10 bg-aviary-oak/70 p-3 font-mono text-sm text-white outline-none transition focus:border-purple-400 focus:ring-0">
                                    <option value="racing">Racing</option>
                                    <option value="exhibition">Exhibition</option>
                                    <option value="highflyer">Highflyer</option>
                                </select>
                                @error('raceForm.race_type') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>

                            {{-- Difficulty Tier --}}
                            <div>
                                <label class="mb-1 block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Difficulty Tier</label>
                                <input wire:model="raceForm.difficulty_tier" type="number" min="1"
                                    class="w-full rounded-xl border border-white/10 bg-aviary-oak/70 p-3 font-mono text-sm text-white outline-none transition focus:border-purple-400 focus:ring-0">
                                @error('raceForm.difficulty_tier') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>

                            {{-- Distance --}}
                            <div>
                                <label class="mb-1 block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Distance (km)</label>
                                <input wire:model="raceForm.distance_km" type="number" min="1"
                                    class="w-full rounded-xl border border-white/10 bg-aviary-oak/70 p-3 font-mono text-sm text-white outline-none transition focus:border-purple-400 focus:ring-0">
                                @error('raceForm.distance_km') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>

                            {{-- Entry Fee --}}
                            <div>
                                <label class="mb-1 block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Entry Fee (🎟️ Tokens)</label>
                                <input wire:model="raceForm.entry_fee" type="number" min="0"
                                    class="w-full rounded-xl border border-white/10 bg-aviary-oak/70 p-3 font-mono text-sm text-white outline-none transition focus:border-purple-400 focus:ring-0">
                                @error('raceForm.entry_fee') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>

                            {{-- Prize Pool --}}
                            <div>
                                <label class="mb-1 block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Prize Pool</label>
                                <input wire:model="raceForm.prize_pool" type="number" min="0"
                                    class="w-full rounded-xl border border-white/10 bg-aviary-oak/70 p-3 font-mono text-sm text-white outline-none transition focus:border-purple-400 focus:ring-0">
                                @error('raceForm.prize_pool') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>

                            {{-- Min Level --}}
                            <div>
                                <label class="mb-1 block text-[9px] font-black uppercase tracking-[0.3em] text-slate-400">Min Loft Level</label>
                                <input wire:model="raceForm.level_requirement" type="number" min="1"
                                    class="w-full rounded-xl border border-white/10 bg-aviary-oak/70 p-3 font-mono text-sm text-white outline-none transition focus:border-purple-400 focus:ring-0">
                                @error('raceForm.level_requirement') <p class="mt-1 text-xs text-red-400">{{ $message }}</p> @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="group inline-flex w-full items-center justify-center rounded-[1.75rem] border border-white/10 bg-purple-600 px-6 py-4 text-sm font-black uppercase italic tracking-[0.25em] text-white shadow-2xl transition-all hover:bg-purple-500">
                            <span class="transition-transform group-hover:scale-[1.02]">{{ $editingRaceId ? 'Update Tournament' : 'Create Tournament' }}</span>
                        </button>
                    </form>
                </div>
            </section>

            {{-- End Tournament Configuration --}}

            <section class="border-t border-white/10 pt-10">
                <div class="flex flex-col gap-4 md:flex-row md:items-end md:justify-between">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.35em] text-aviary-blue">Network Intelligence</p>
                        <h3 class="mt-2 text-3xl font-black italic uppercase text-white">AI loft monitoring</h3>
                    </div>
                    <p class="max-w-2xl text-sm leading-relaxed text-slate-300/70">
                        Inspect automated specimens and event logs from the network panel. The selected loft stays pinned while you review it.
                    </p>
                </div>

                <div class="mt-8 grid grid-cols-1 gap-8 xl:grid-cols-[0.95fr_1.05fr]">
                    <div class="rounded-[2.75rem] border border-white/10 bg-white/5 p-6 shadow-2xl md:p-8">
                        <p class="text-[10px] font-black uppercase tracking-[0.35em] text-aviary-blue">AI Registry</p>
                        <div class="mt-5 max-h-[34rem] space-y-4 overflow-y-auto pr-2 custom-scrollbar">
                            @foreach($aiLofts as $loft)
                                <button
                                    wire:click="selectAiLoft({{ $loft->id }})"
                                    class="group relative w-full overflow-hidden rounded-[2rem] border p-5 text-left transition-all duration-300
                                        {{ $selectedAiLoftId == $loft->id ? 'border-aviary-blue bg-aviary-blue/10 shadow-xl shadow-aviary-blue/10' : 'border-white/10 bg-black/20 hover:border-white/20' }}"
                                >
                                    <div class="relative z-10 flex items-center justify-between gap-4">
                                        <div class="min-w-0">
                                            <p class="truncate text-lg font-black italic uppercase text-white">{{ $loft->name }}</p>
                                            <div class="mt-2 flex flex-wrap items-center gap-3 text-[10px] font-black uppercase tracking-[0.22em] text-slate-400">
                                                <span>Grade {{ $loft->level }}</span>
                                                <span class="h-1 w-1 rounded-full bg-white/20"></span>
                                                <span>{{ $loft->pigeons_count }} birds</span>
                                            </div>
                                        </div>
                                        <div class="shrink-0 text-right">
                                            <p class="text-[10px] font-black uppercase tracking-[0.22em] text-aviary-brass">AI wealth</p>
                                            <p class="mt-1 text-sm font-black text-white">{{ number_format($loft->coins) }}💰</p>
                                        </div>
                                    </div>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-[2.75rem] border border-white/10 bg-white/5 p-6 shadow-2xl md:p-8">
                        <p class="text-[10px] font-black uppercase tracking-[0.35em] text-aviary-brass">Inspector</p>
                        <h3 class="mt-2 text-2xl font-black italic uppercase text-white">Live specimen log</h3>

                        @if($selectedAiLoft)
                            <div class="mt-6 grid gap-6 lg:grid-cols-2">
                                <div>
                                    <p class="mb-4 text-[10px] font-black uppercase tracking-[0.3em] text-aviary-blue">Specimen inventory</p>
                                    <div class="max-h-[28rem] space-y-3 overflow-y-auto pr-2 custom-scrollbar">
                                        @foreach($selectedAiLoft->pigeons as $p)
                                            <div class="flex items-center justify-between gap-4 rounded-2xl border border-white/10 bg-black/20 p-4">
                                                <div class="min-w-0">
                                                    <p class="truncate text-sm font-black italic uppercase text-white">{{ $p->name }}</p>
                                                    <p class="mt-1 text-[10px] font-black uppercase tracking-[0.22em] {{ $p->gender == 'male' ? 'text-aviary-blue' : 'text-aviary-rose' }}">
                                                        Lv.{{ $p->level }} {{ $p->type }} · {{ $p->gender == 'male' ? 'cock' : 'hen' }}
                                                    </p>
                                                </div>
                                                <span class="rounded-full border border-white/10 bg-white/5 px-3 py-1 text-[10px] font-black uppercase tracking-[0.22em] text-slate-300">
                                                    Cond {{ $p->energy }}%
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <p class="mb-4 text-[10px] font-black uppercase tracking-[0.3em] text-aviary-brass">Intelligence logs</p>
                                    <div class="max-h-[28rem] space-y-3 overflow-y-auto pr-2 custom-scrollbar">
                                        @forelse($aiLoftLogs as $log)
                                            <div class="rounded-2xl border border-white/10 bg-black/20 p-4">
                                                <p class="text-[9px] font-black uppercase tracking-[0.25em] text-aviary-brass">
                                                    {{ $log->created_at->format('Y-m-d H:i:s') }}
                                                </p>
                                                <p class="mt-2 text-sm leading-relaxed text-slate-300/80">
                                                    {{ $log->description }}
                                                </p>
                                            </div>
                                        @empty
                                            <div class="rounded-2xl border border-dashed border-white/10 bg-black/20 p-6 text-center">
                                                <p class="text-sm font-semibold text-slate-400">No intelligence records found.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="mt-6 rounded-[2rem] border border-dashed border-white/10 bg-black/20 p-10 text-center">
                                <div class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-full border border-white/10 bg-white/5">
                                    <svg class="h-8 w-8 text-aviary-blue/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2m6-2a10 10 0 11-20 0 10 10 0 0120 0z" />
                                    </svg>
                                </div>
                                <p class="text-xl font-black italic uppercase text-white">Registry analysis required</p>
                                <p class="mt-3 text-sm leading-relaxed text-slate-400">
                                    Select an AI loft to inspect the birds and their recent activity.
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        </div>
    </section>

    <style>
        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .animate-spin-slow {
            animation: spin-slow 15s linear infinite;
        }
    </style>
</div>
