<div class="p-6 max-w-7xl mx-auto text-slate-200">
    @if (session()->has('message'))
        <div class="bg-green-600 text-white p-4 rounded-lg mb-4">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-600 text-white p-4 rounded-lg mb-4">{{ session('error') }}</div>
    @endif

    <livewire:my-listings />

    <h2 class="text-2xl font-black text-white mb-6 mt-12">Available on Marketplace</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($listings as $listing)
            <div class="bg-slate-900 p-6 rounded-2xl border border-slate-700">
                <h3 class="font-bold text-lg text-white">{{ $listing->pigeon->name }} <span class="text-xs text-yellow-500 font-bold ml-1">Lv.{{ $listing->pigeon->level }}</span></h3>
                @php
                    $status = 'Adult';
                    if (!$listing->pigeon->hatch_at || $listing->pigeon->hatch_at->isFuture()) $status = 'Egg';
                    elseif ($listing->pigeon->hatch_at->addDay()->isFuture()) $status = 'Hatchling';
                    elseif ($listing->pigeon->birth_at->addDays(4)->isFuture()) $status = 'Juvenile';
                @endphp
                <p class="text-xs text-slate-400 mb-4">{{ ucfirst($listing->pigeon->type) }} • {{ ucfirst($listing->pigeon->rarity) }} • {{ ucfirst($listing->pigeon->gender) }} • {{ $status }}</p>
                
                <div class="grid grid-cols-2 gap-2 text-[10px] mb-4">
                    <div class="bg-slate-800 p-1 rounded">🏃 Spd: {{ $listing->pigeon->speed }}</div>
                    <div class="bg-slate-800 p-1 rounded">🔋 End: {{ $listing->pigeon->endurance }}</div>
                    <div class="bg-slate-800 p-1 rounded">🧭 Nav: {{ $listing->pigeon->navigation }}</div>
                    <div class="bg-slate-800 p-1 rounded">🧘 Temp: {{ $listing->pigeon->temperament }}</div>
                </div>

                <div class="grid grid-cols-2 gap-2 text-[9px] mb-4 text-slate-300">
                    <div>👁️ Eyes: {{ $listing->pigeon->eyes }}</div>
                    <div>👃 Beak: {{ $listing->pigeon->beak }}</div>
                    <div>🦵 Legs: {{ $listing->pigeon->legs }}</div>
                    <div>🪶 Qual: {{ $listing->pigeon->feather_quality }}</div>
                    <div>🎨 Patt: {{ $listing->pigeon->pattern }}</div>
                    <div>🌈 Color: {{ $listing->pigeon->color }}</div>
                    <div>💎 Purity: {{ $listing->pigeon->purity }}</div>
                </div>

                <div class="text-xs text-slate-500 mb-4 font-bold">
                    Beauty: {{ number_format($listing->pigeon->beauty, 1) }}
                </div>

                <div class="text-yellow-500 font-black text-xl mb-4">{{ number_format($listing->price) }} 💰</div>
                <button wire:click="buy({{ $listing->id }})" class="w-full bg-yellow-500 text-black font-bold py-2 rounded-lg hover:bg-yellow-400">
                    Buy Pigeon
                </button>
            </div>
        @endforeach
    </div>
</div>
