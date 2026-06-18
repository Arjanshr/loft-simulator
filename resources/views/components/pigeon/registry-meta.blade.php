@props([
    'pigeon',
    'size' => 'md',
    'showRarity' => true,
    'showPrice' => true,
    'stacked' => false,
    'priceLabel' => 'EST. VALUE',
    'rarityLabel' => 'RARITY',
])

@php
    $sizeClasses = [
        'sm' => [
            'badge' => 'px-2.5 py-1 text-[8px] tracking-[0.18em]',
            'value' => 'text-[10px]',
        ],
        'md' => [
            'badge' => 'px-3 py-1.5 text-[9px] tracking-[0.22em]',
            'value' => 'text-xs',
        ],
        'lg' => [
            'badge' => 'px-4 py-2 text-[10px] tracking-[0.28em]',
            'value' => 'text-sm',
        ],
    ][$size] ?? [
        'badge' => 'px-3 py-1.5 text-[9px] tracking-[0.22em]',
        'value' => 'text-xs',
    ];

    $rarityClasses = match (strtolower((string) $pigeon->rarity)) {
        'mythic' => 'bg-purple-900/35 text-purple-200 border-purple-500/30 shadow-[0_0_12px_rgba(168,85,247,0.12)]',
        'legendary' => 'bg-yellow-900/35 text-yellow-200 border-yellow-500/30 shadow-[0_0_12px_rgba(234,179,8,0.12)]',
        'super_rare' => 'bg-sky-900/35 text-sky-200 border-sky-500/30 shadow-[0_0_12px_rgba(14,165,233,0.12)]',
        'rare' => 'bg-emerald-900/25 text-emerald-200 border-emerald-500/20 shadow-[0_0_12px_rgba(16,185,129,0.10)]',
        default => 'bg-black/35 text-aviary-feather/60 border-white/10',
    };
@endphp

<div {{ $attributes->merge(['class' => $stacked ? 'flex flex-col gap-2' : 'flex flex-wrap gap-2 items-center']) }}>
    @if($showRarity)
        <span class="inline-flex items-center gap-2 rounded-full border uppercase font-black italic {{ $sizeClasses['badge'] }} {{ $rarityClasses }}">
            <span class="h-1.5 w-1.5 rounded-full bg-current opacity-80"></span>
            {{ strtoupper(str_replace('_', ' ', $rarityLabel)) }}: {{ strtoupper(str_replace('_', ' ', $pigeon->rarity)) }}
        </span>
    @endif

    @if($showPrice)
        <span class="inline-flex items-center gap-2 rounded-full border bg-aviary-brass/10 text-aviary-brass border-aviary-brass/20 uppercase font-black italic {{ $sizeClasses['badge'] }} shadow-[0_0_12px_rgba(184,134,11,0.12)]">
            <span class="opacity-70">{{ strtoupper($priceLabel) }}</span>
            <span class="font-mono not-italic {{ $sizeClasses['value'] }}">{{ number_format($pigeon->fixed_price) }} COINS</span>
        </span>
    @endif
</div>
