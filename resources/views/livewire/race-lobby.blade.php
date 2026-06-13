<div class="text-slate-200">
    @if (session()->has('race_error'))
        <div class="bg-red-900 border border-red-700 text-red-200 px-4 py-2 rounded text-sm mb-4">
            {{ session('race_error') }}
        </div>
    @endif

    <div class="mb-6">
        <label class="block text-slate-400 text-sm font-bold mb-2">Select Your Pigeon</label>
        <select wire:model="selectedPigeonId" class="w-full bg-slate-900 border border-slate-700 rounded p-2 text-sm text-white focus:ring-2 focus:ring-yellow-500">
            <option value="">-- Choose a Bird --</option>
            @foreach($readyPigeons as $p)
                <option value="{{ $p->id }}">{{ $p->name }} (Lv.{{ $p->level }} - {{ ucfirst($p->type) }})</option>
            @endforeach
        </select>
    </div>

    <div class="space-y-4">
        @foreach($races as $race)
            <div class="border rounded-lg p-4 bg-slate-800 border-slate-700 hover:border-yellow-600 transition group">
                <div class="flex justify-between items-center">
                    <div>
                        <h4 class="font-bold text-white">{{ $race->title }}</h4>
                        <div class="text-xs text-slate-400 space-x-1">
                            <span class="uppercase font-bold text-yellow-500">{{ $race->race_type }}</span>
                            <span>• {{ $race->distance_km }}km</span>
                            <span>• Req. Level: {{ $race->level_requirement }}</span>
                            <span>• Fee: {{ number_format($race->entry_fee) }}</span>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-sm font-bold text-green-400">🏆 {{ number_format($race->prize_pool) }}</span>
                        <button 
                            wire:click="enterRace({{ $race->id }})"
                            class="mt-2 bg-slate-900 group-hover:bg-yellow-500 group-hover:text-black text-yellow-500 text-[10px] font-bold py-1 px-3 rounded uppercase transition"
                        >
                            Enter
                        </button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
