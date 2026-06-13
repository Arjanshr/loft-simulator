<div class="p-6 max-w-4xl mx-auto text-slate-200">
    @if (session()->has('message'))
        <div class="bg-green-600 text-white p-4 rounded-lg mb-4">{{ session('message') }}</div>
    @endif
    @if (session()->has('error'))
        <div class="bg-red-600 text-white p-4 rounded-lg mb-4">{{ session('error') }}</div>
    @endif

    <div class="mb-6 flex justify-between items-center bg-slate-900 p-6 rounded-2xl border border-slate-700">
        <h2 class="text-xl font-black text-white">Breeding Cages: {{ $pairs->count() }} / {{ Auth::user()->loft->level }}</h2>
        <p class="text-slate-400 text-sm">Each Loft Level unlocks 1 breeding cage.</p>
    </div>

    @if($pairs->count() < Auth::user()->loft->level)
        <div class="bg-slate-900 p-8 rounded-2xl shadow-xl border border-slate-700 mb-8">
            <h2 class="text-2xl font-black text-white mb-6">Create New Pair</h2>
            <form wire:submit="createPair" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                <div>
                    <label class="block text-slate-400 text-xs font-bold mb-2">Male</label>
                    <select wire:model="maleId" class="w-full bg-slate-800 border-none rounded-lg p-3 text-white">
                        <option value="">Select Male</option>
                        @foreach($males as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-slate-400 text-xs font-bold mb-2">Female</label>
                    <select wire:model="femaleId" class="w-full bg-slate-800 border-none rounded-lg p-3 text-white">
                        <option value="">Select Female</option>
                        @foreach($females as $p) <option value="{{ $p->id }}">{{ $p->name }}</option> @endforeach
                    </select>
                </div>
                <button type="submit" class="bg-yellow-500 text-black font-bold py-3 rounded-lg hover:bg-yellow-400 transition">Pair Pigeons</button>
            </form>
        </div>
    @else
        <div class="bg-slate-900 p-8 rounded-2xl shadow-xl border border-yellow-600 mb-8 text-center text-yellow-500 font-bold">
            All breeding cages are occupied! Upgrade your loft to unlock more.
        </div>
    @endif

    <h2 class="text-2xl font-black text-white mb-6">Active Pairs</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @foreach($pairs as $pair)
            @php
                $record = $breedingRecords->where('sire_id', $pair->male_id)->where('dam_id', $pair->female_id)->first();
            @endphp
            <div class="bg-slate-900 p-6 rounded-xl border border-slate-700 flex justify-between items-center">
                <div class="font-bold text-slate-300">
                    {{ $pair->male->name }} ♂ + {{ $pair->female->name }} ♀
                    @if($record)
                        @php
                            $hatchTime = $record->eggs_laid_at->addDay();
                            $remaining = now()->diffInSeconds($hatchTime, false);
                        @endphp
                        <span class="block text-[10px] text-yellow-500 font-normal">
                            @if($remaining > 0)
                                Incubation: {{ gmdate("H:i:s", $remaining) }} remaining
                            @else
                                Ready to hatch!
                            @endif
                        </span>
                    @endif
                </div>
                <div class="flex gap-2">
                    @if(!$record)
                        <button wire:click="breedPair({{ $pair->id }})" class="bg-indigo-600 text-white text-xs font-bold px-3 py-1 rounded hover:bg-indigo-500 transition">
                            Breed (100 💰)
                        </button>
                        <button wire:click="disband({{ $pair->id }})" class="bg-red-600 text-white text-xs font-bold px-3 py-1 rounded hover:bg-red-500 transition">
                            Disband
                        </button>
                    @else
                        <span class="text-xs text-slate-500 italic">Busy</span>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
