<div class="flex flex-col items-end gap-1 font-sans" wire:poll.60s>
    @if($loft)
        <div class="flex items-center gap-4 bg-black/60 px-5 py-2 rounded-2xl border border-[#b8860b]/30 shadow-2xl">
            <span class="text-[#b8860b] font-industrial font-black text-xl tracking-widest italic">💰 {{ number_format($loft->coins) }}</span>
        </div>
        <div class="flex items-center gap-2 mr-1">
            <span class="w-1.5 h-1.5 rounded-full bg-green-600 animate-pulse"></span>
            <span class="text-[9px] font-black text-slate-500 uppercase tracking-widest italic">
                +{{ number_format($loft->total_passive_income, 1) }} / MIN INCOME
            </span>
        </div>
    @endif
</div>
