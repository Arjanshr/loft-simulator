<div class="flex items-center justify-center min-h-[60vh] font-sans">
    <div class="relative overflow-hidden rounded-[3rem] border border-white/10 bg-[linear-gradient(180deg,rgba(15,23,42,0.96),rgba(2,6,23,0.98))] p-8 text-center shadow-[0_30px_120px_rgba(0,0,0,0.45)] md:p-14 max-w-xl">
        <div class="absolute inset-0 pointer-events-none bg-[radial-gradient(circle_at_top,rgba(184,134,11,0.08),transparent_50%)]"></div>

        <div class="relative z-10 flex flex-col items-center gap-6">
            {{-- Lock Icon --}}
            <div class="flex h-20 w-20 items-center justify-center rounded-full border border-aviary-brass/20 bg-aviary-brass/5 shadow-[0_0_30px_rgba(184,134,11,0.15)]">
                <svg class="w-10 h-10 text-aviary-brass/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>

            {{-- Title --}}
            <div class="space-y-2">
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-aviary-brass/60">Feature Locked</p>
                <h2 class="text-3xl font-industrial font-black uppercase italic text-white md:text-4xl">{{ $feature }}</h2>
            </div>

            {{-- Level Requirement --}}
            <div class="rounded-2xl border border-white/10 bg-black/30 px-8 py-5">
                <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400 mb-3">Level Requirement</p>
                <div class="flex items-center justify-center gap-4">
                    <div class="text-center">
                        <p class="text-3xl font-industrial font-black text-red-400">Lv.{{ $currentLevel }}</p>
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mt-1">Your Loft</p>
                    </div>
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                    </svg>
                    <div class="text-center">
                        <p class="text-3xl font-industrial font-black text-aviary-brass">Lv.{{ $requiredLevel }}</p>
                        <p class="text-[9px] font-black uppercase tracking-widest text-slate-500 mt-1">Required</p>
                    </div>
                </div>
            </div>

            {{-- Progress --}}
            <div class="w-full max-w-xs">
                <div class="flex justify-between mb-2">
                    <span class="text-[9px] font-black uppercase tracking-widest text-slate-500">Progress</span>
                    <span class="text-[9px] font-black uppercase tracking-widest text-aviary-brass">{{ $currentLevel }}/{{ $requiredLevel }}</span>
                </div>
                <div class="h-2 rounded-full bg-black/40 border border-white/5 overflow-hidden">
                    <div class="h-full rounded-full bg-aviary-brass/60 transition-all duration-500" style="width: {{ min(100, ($currentLevel / $requiredLevel) * 100) }}%"></div>
                </div>
            </div>

            {{-- Hint --}}
            <p class="text-sm text-slate-400 max-w-sm leading-relaxed">
                Upgrade your loft level by earning <span class="text-white font-bold">XP</span> through racing, tournaments, and other activities to unlock this feature.
            </p>

            {{-- Back Button --}}
            <a href="{{ route('dashboard') }}" wire:navigate
                class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-6 py-3 text-[10px] font-black uppercase tracking-[0.3em] text-slate-300 transition-all hover:bg-aviary-brass/10 hover:text-aviary-brass hover:border-aviary-brass/30">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12" />
                </svg>
                Return to Loft
            </a>
        </div>
    </div>
</div>
