<div class="flex flex-col items-end gap-1 font-sans" wire:poll.60s>
    @if($loft)
        <div class="flex items-center gap-4 bg-aviary-oak px-5 py-2 rounded-2xl border border-aviary-brass/30 shadow-2xl galvanized-border">
            <span class="text-aviary-brass font-industrial font-black text-xl tracking-widest italic drop-shadow-[0_0_8px_rgba(184,134,11,0.3)]">💰 {{ number_format($loft->coins) }}</span>
            <span class="text-emerald-400 font-industrial font-black text-xl tracking-widest italic drop-shadow-[0_0_8px_rgba(52,211,153,0.3)]">💊 {{ number_format($loft->vitamins) }}</span>
        </div>
        <div class="flex items-center gap-4 mr-1">
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-aviary-blue animate-pulse shadow-[0_0_8px_#3b82f6]"></span>
                <span class="text-[9px] font-mono font-bold text-aviary-feather/50 uppercase tracking-widest italic">
                    +{{ number_format($loft->total_passive_income, 1) }} 💰/MIN
                </span>
            </div>
            <div class="flex items-center gap-2">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse shadow-[0_0_8px_#10b981]"></span>
                <span class="text-[9px] font-mono font-bold text-aviary-feather/50 uppercase tracking-widest italic">
                    +{{ number_format($loft->total_vitamin_income, 1) }} 💊/MIN
                </span>
            </div>
        </div>
    @endif
</div>
