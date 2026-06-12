<div>
    @if (session()->has('race_error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded text-sm mb-4">
            {{ session('race_error') }}
        </div>
    @endif

    <div class="mb-6">
        <label class="block text-gray-700 text-sm font-bold mb-2">Select Your Pigeon</label>
        <select wire:model="selectedPigeonId" class="w-full border rounded p-2 text-sm">
            <option value="">-- Choose a Bird --</option>
            @foreach($readyPigeons as $p)
                <option value="{{ $p->id }}">{{ $p->name }} (S:{{ $p->speed }} E:{{ $p->endurance }})</option>
            @endforeach
        </select>
    </div>

    <div class="space-y-4">
        @foreach($races as $race)
            <div class="border rounded-lg p-4 hover:border-blue-300 transition group">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-gray-800">{{ $race->title }}</h4>
                        <p class="text-xs text-gray-500">{{ $race->distance_km }}km • Fee: {{ number_format($race->entry_fee) }} coins</p>
                    </div>
                    <div class="text-right">
                        <span class="block text-sm font-bold text-green-600">🏆 {{ number_format($race->prize_pool) }}</span>
                        <button 
                            wire:click="enterRace({{ $race->id }})"
                            class="mt-2 bg-indigo-50 group-hover:bg-indigo-600 group-hover:text-white text-indigo-700 text-[10px] font-bold py-1 px-3 rounded uppercase transition"
                        >
                            Enter
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
