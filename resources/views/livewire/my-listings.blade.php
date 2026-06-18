<div class="text-slate-300 font-sans">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Sell Form -->
        <div>
            <div class="flex items-center gap-5 mb-8">
                <div class="w-8 h-1 bg-aviary-brass rounded-full shadow-[0_0_10px_#b8860b]"></div>
                <h3 class="text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Loft Birds</h3>
            </div>

            <div class="grid grid-cols-1 gap-4 max-h-[600px] overflow-y-auto custom-scrollbar pr-2">
                @foreach($idlePigeons as $pigeon)
                    <div class="bg-aviary-oak/40 border border-aviary-brass/10 rounded-2xl p-5 flex justify-between items-center group hover:border-aviary-blue/30 transition-all shadow-lg relative overflow-hidden galvanized-border">
                        <div class="absolute top-0 right-0 p-2 opacity-5 text-xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">Ready</div>
                        <div class="relative z-10">
                            <p class="font-industrial font-black text-white uppercase tracking-widest text-base italic">{{ $pigeon->name }}</p>
                            <p class="text-[9px] font-black text-aviary-feather/40 uppercase tracking-[0.2em] mt-1 italic">LV.{{ $pigeon->level }} â€¢ {{ $pigeon->type }} Strain</p>
                            <x-pigeon.registry-meta :pigeon="$pigeon" size="sm" class="mt-3" />
                        </div>
                        <div class="flex gap-6 items-center relative z-10">
                            <button wire:click="listPigeon({{ $pigeon->id }})"
                                    class="bg-aviary-brass hover:bg-aviary-blue text-white font-industrial font-black px-5 py-2.5 rounded-xl transition shadow-xl text-[10px] uppercase tracking-widest italic border border-white/10">
                                List Bird
                            </button>
                        </div>
                    </div>
                @endforeach
                @if($idlePigeons->isEmpty())
                    <div class="py-12 border-2 border-dashed border-aviary-brass/10 rounded-[2rem] text-center bg-black/10">
                        <p class="text-[10px] font-black text-aviary-feather/30 uppercase tracking-[0.3em] italic">No eligible birds available for auction</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- My Active Listings -->
        <div>
            <div class="flex items-center gap-5 mb-8">
                <div class="w-8 h-1 bg-aviary-brass rounded-full shadow-[0_0_10px_#b8860b]"></div>
                <h3 class="text-2xl font-industrial font-black text-white uppercase italic tracking-widest">Active Auctions</h3>
            </div>

            <div class="grid grid-cols-1 gap-4 max-h-[600px] overflow-y-auto custom-scrollbar pr-2">
                @foreach($myListings as $listing)
                    <div class="bg-aviary-oak/60 border border-aviary-brass/20 rounded-2xl p-5 flex justify-between items-center relative overflow-hidden shadow-2xl galvanized-border">
                        <div class="absolute top-0 right-0 p-3 opacity-5 text-3xl font-industrial font-black italic select-none pointer-events-none uppercase text-aviary-brass">Selling</div>
                        <div class="relative z-10">
                            <h4 class="font-industrial font-black text-white uppercase tracking-widest text-base italic leading-none mb-2">{{ $listing->pigeon->name }}</h4>
                            <x-pigeon.registry-meta :pigeon="$listing->pigeon" size="sm" class="mb-3" />
                            @php
                                $remainingSecs = now()->diffInSeconds($listing->expires_at, false);
                            @endphp
                            <div class="flex items-center gap-2">
                                <div class="w-1.5 h-1.5 rounded-full bg-aviary-brass animate-pulse shadow-[0_0_8px_#b8860b]"></div>
                                <p class="text-[9px] font-black text-aviary-brass/60 uppercase tracking-widest italic">
                                    Ends in: {{ $remainingSecs > 0 ? gmdate("H:i:s", $remainingSecs) : 'EXPIRED' }}
                                </p>
                            </div>
                        </div>
                        <div class="relative z-10 text-2xl font-industrial font-black text-aviary-brass italic drop-shadow-lg">
                            {{ number_format($listing->price) }} COINS
                        </div>
                    </div>
                @endforeach
                @if($myListings->isEmpty())
                    <div class="py-12 border-2 border-dashed border-aviary-brass/10 rounded-[2rem] text-center bg-black/10">
                        <p class="text-[10px] font-black text-aviary-feather/30 uppercase tracking-[0.3em] italic">No active bids in the exchange ledger</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
