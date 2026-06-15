@props(['active', 'icon', 'minimal' => false])

@php
$baseClasses = 'flex flex-col lg:flex-row items-center lg:justify-start gap-1 lg:gap-4 px-2 lg:px-4 py-2 lg:py-3 rounded-xl transition-all group';

if ($minimal) {
    $classes = ($active ?? false)
        ? 'text-yellow-500 font-black'
        : 'text-slate-500 hover:text-yellow-500';
} else {
    $classes = ($active ?? false)
        ? 'bg-yellow-500 text-black font-black shadow-lg shadow-yellow-500/20'
        : 'text-slate-400 hover:bg-slate-900 hover:text-yellow-500';
}
@endphp

<a {{ $attributes->merge(['class' => $baseClasses . ' ' . $classes]) }} wire:navigate>
    <svg class="w-5 h-5 lg:w-6 lg:h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
    </svg>
    <span class="text-[8px] lg:text-sm font-black lg:font-bold uppercase tracking-tighter lg:tracking-normal">{{ $slot }}</span>
</a>
