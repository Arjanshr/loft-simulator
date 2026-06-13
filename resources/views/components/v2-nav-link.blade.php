@props(['active', 'icon'])

@php
$classes = ($active ?? false)
            ? 'flex items-center justify-center lg:justify-start gap-4 px-4 py-3 rounded-xl bg-yellow-500 text-black font-black transition-all shadow-lg shadow-yellow-500/20'
            : 'flex items-center justify-center lg:justify-start gap-4 px-4 py-3 rounded-xl text-slate-400 hover:bg-slate-900 hover:text-yellow-500 transition-all group';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }} wire:navigate>
    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
    </svg>
    <span class="hidden lg:block font-bold text-sm">{{ $slot }}</span>
</a>
