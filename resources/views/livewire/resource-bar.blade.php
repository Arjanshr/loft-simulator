<div class="flex flex-col items-end gap-1" wire:poll.60s>
    @if($loft)
        <div class="flex items-center gap-4 bg-black/40 px-4 py-2 rounded-full border border-yellow-500/30 shadow-lg shadow-yellow-500/5">
            <span class="text-yellow-500 font-industrial font-black text-lg tracking-wider">💰 {{ number_format($loft->coins) }}</span>
        </div>
        <span class="text-[9px] font-black text-slate-500 uppercase tracking-[0.2em] mr-2">
            +{{ number_format($loft->total_passive_income, 1) }} 💰 / MIN
        </span>
    @endif
</div>
