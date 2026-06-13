<div class="text-slate-200">
    <!-- Sell Pigeons -->
    <h2 class="text-2xl font-black text-white mb-6">List a Pigeon</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-12">
        @foreach($idlePigeons as $pigeon)
            <div class="bg-slate-900 p-4 rounded-xl border border-slate-700">
                <p class="font-bold text-white">{{ $pigeon->name }}</p>
                <input type="number" wire:model="price.{{ $pigeon->id }}" placeholder="Price (💰)" class="w-full bg-slate-800 border-none rounded p-2 text-sm text-white my-2">
                <button wire:click="listPigeon({{ $pigeon->id }})" class="w-full bg-yellow-500 text-black font-bold py-2 rounded hover:bg-yellow-400">
                    List for Sale
                </button>
            </div>
        @endforeach
    </div>

    <!-- Active Listings -->
    <h2 class="text-2xl font-black text-white mb-6">Your Active Listings</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($myListings as $listing)
            <div class="bg-slate-900 p-6 rounded-2xl border border-slate-700">
                <h3 class="font-bold text-white">{{ $listing->pigeon->name }}</h3>
                <p class="text-yellow-500 font-black text-xl">{{ number_format($listing->price) }} 💰</p>
            </div>
        @endforeach
    </div>
</div>
