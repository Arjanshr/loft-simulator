<div class="flex flex-col items-end gap-1 font-sans" wire:poll.60s>
    @if($loft)
        <div class="flex items-center gap-1.5 bg-aviary-oak px-2 py-1.5 rounded-2xl border border-aviary-brass/30 shadow-2xl galvanized-border sm:gap-2 sm:px-3 sm:py-2">

            {{-- Coins --}}
            <div class="relative group cursor-help">
                <div class="flex items-center gap-1.5 bg-aviary-timber/60 px-2 py-1.5 rounded-xl border border-aviary-brass/10 hover:border-aviary-brass/30 transition-all shadow-inner sm:gap-2 sm:px-3 sm:py-2 sm:rounded-2xl">
                    <span class="text-sm sm:text-lg">💰</span>
                    <span class="font-mono text-white text-[11px] font-bold leading-none sm:text-sm">{{ number_format($loft->coins) }}</span>
                    <span class="hidden sm:block text-[8px] uppercase tracking-[0.2em] text-aviary-brass font-bold italic leading-none ml-0.5">Coins</span>
                </div>
                {{-- Tooltip (md+) --}}
                <div class="hidden md:block absolute top-full left-1/2 -translate-x-1/2 mt-2 w-48 bg-aviary-timber border border-aviary-brass/10 rounded-xl p-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 shadow-2xl pointer-events-none">
                    <div class="text-[9px] uppercase tracking-widest text-aviary-brass mb-1 font-bold">Passive Generation</div>
                    <div class="text-[10px] text-white font-mono">
                        @if($loft->total_passive_income > 0)
                            +{{ number_format($loft->total_passive_income, 1) }} 💰/MIN
                        @else
                            No passive income.<br><span class="text-aviary-feather/50 mt-1 block">Acquire Fancy strain pigeons to generate coins.</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Vitamins --}}
            <div class="relative group cursor-help">
                <div class="flex items-center gap-1.5 bg-aviary-timber/60 px-2 py-1.5 rounded-xl border border-aviary-brass/10 hover:border-emerald-400/30 transition-all shadow-inner sm:gap-2 sm:px-3 sm:py-2 sm:rounded-2xl">
                    <span class="text-sm sm:text-lg">💊</span>
                    <span class="font-mono text-white text-[11px] font-bold leading-none sm:text-sm">{{ number_format($loft->vitamins) }}</span>
                    <span class="hidden sm:block text-[8px] uppercase tracking-[0.2em] text-emerald-400 font-bold italic leading-none ml-0.5">Vitamins</span>
                </div>
                {{-- Tooltip (md+) --}}
                <div class="hidden md:block absolute top-full left-1/2 -translate-x-1/2 mt-2 w-48 bg-aviary-timber border border-aviary-brass/10 rounded-xl p-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 shadow-2xl pointer-events-none">
                    <div class="text-[9px] uppercase tracking-widest text-emerald-400 mb-1 font-bold">Passive Generation</div>
                    <div class="text-[10px] text-white font-mono">
                        @if($loft->total_vitamin_income > 0)
                            +{{ number_format($loft->total_vitamin_income, 1) }} 💊/MIN
                        @else
                            No passive income.<br><span class="text-aviary-feather/50 mt-1 block">Acquire Highflyer strain pigeons to generate vitamins.</span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Tokens --}}
            <div class="relative group cursor-help">
                <div class="flex items-center gap-1.5 bg-aviary-timber/60 px-2 py-1.5 rounded-xl border border-aviary-brass/10 hover:border-purple-400/30 transition-all shadow-inner sm:gap-2 sm:px-3 sm:py-2 sm:rounded-2xl">
                    <span class="text-sm sm:text-lg">🎟️</span>
                    <span class="font-mono text-white text-[11px] font-bold leading-none sm:text-sm">{{ number_format($loft->tokens) }}</span>
                    <span class="hidden sm:block text-[8px] uppercase tracking-[0.2em] text-purple-400 font-bold italic leading-none ml-0.5">Tokens</span>
                </div>
                {{-- Tooltip (md+) --}}
                <div class="hidden md:block absolute top-full right-0 mt-2 w-48 bg-aviary-timber border border-aviary-brass/10 rounded-xl p-3 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 shadow-2xl pointer-events-none">
                    <div class="text-[9px] uppercase tracking-widest text-purple-400 mb-1 font-bold">Passive Generation</div>
                    <div class="text-[10px] text-white font-mono">
                        @if($loft->total_token_income > 0)
                            +{{ number_format($loft->total_token_income, 1) }} 🎟️/MIN
                        @else
                            No passive income.<br><span class="text-aviary-feather/50 mt-1 block">Acquire Racer strain pigeons to generate tokens.</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- Income Rate Indicators --}}
        <div class="flex items-center gap-2 mr-1 sm:gap-3">
            <div class="flex items-center gap-1 sm:gap-1.5 sm:bg-aviary-oak/60 sm:px-2.5 sm:py-1 sm:rounded-full sm:border sm:border-aviary-brass/10">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-aviary-blue animate-pulse shadow-[0_0_6px_#3b82f6]"></span>
                <span class="text-[9px] font-mono font-bold text-aviary-brass uppercase tracking-wider italic sm:text-[11px]">
                    +{{ number_format($loft->total_passive_income, 1) }} 💰
                </span>
            </div>
            <div class="flex items-center gap-1 sm:gap-1.5 sm:bg-aviary-oak/60 sm:px-2.5 sm:py-1 sm:rounded-full sm:border sm:border-emerald-500/10">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_6px_#10b981]"></span>
                <span class="text-[9px] font-mono font-bold text-emerald-400 uppercase tracking-wider italic sm:text-[11px]">
                    +{{ number_format($loft->total_vitamin_income, 1) }} 💊
                </span>
            </div>
            <div class="flex items-center gap-1 sm:gap-1.5 sm:bg-aviary-oak/60 sm:px-2.5 sm:py-1 sm:rounded-full sm:border sm:border-purple-500/10">
                <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-purple-500 animate-pulse shadow-[0_0_6px_#a855f7]"></span>
                <span class="text-[9px] font-mono font-bold text-purple-400 uppercase tracking-wider italic sm:text-[11px]">
                    +{{ number_format($loft->total_token_income, 1) }} 🎟️
                </span>
            </div>
        </div>
    @endif
</div>
