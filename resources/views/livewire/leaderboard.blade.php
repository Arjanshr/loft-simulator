<div class="bg-slate-900 p-6 rounded-2xl shadow-sm border border-slate-700">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-black text-white">Global Rankings</h2>
        <select wire:model.live="filter" class="bg-slate-800 border-none rounded-lg text-xs p-2 text-white">
            <option value="overall">Overall</option>
            <option value="fancy">Fancy</option>
            <option value="racer">Racer</option>
            <option value="highflyer">High Flyer</option>
        </select>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <!-- Top Pigeons -->
        <div>
            <h3 class="font-bold text-slate-400 text-sm mb-3 uppercase tracking-wider">Top Pigeons</h3>
            <div class="space-y-1">
                @foreach($topPigeons as $index => $pigeon)
                    <div class="flex justify-between items-center text-xs p-2 {{ $index % 2 === 0 ? 'bg-slate-800' : 'bg-slate-950' }} rounded">
                        <div class="truncate">
                            <span class="font-bold text-yellow-500 w-8 inline-block">#{{ $index + 1 }}</span>
                            <span class="font-medium text-white">{{ $pigeon->name }}</span>
                            <span class="text-[10px] text-slate-500">({{ ucfirst($pigeon->type) }} @ {{ $pigeon->loft->name }})</span>
                        </div>
                        <span class="font-black text-yellow-500">{{ number_format($pigeon->total_score, 1) }}</span>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Top Lofts -->
        <div>
            <h3 class="font-bold text-slate-400 text-sm mb-3 uppercase tracking-wider">Top Lofts</h3>
            <div class="space-y-1">
                @foreach($topLofts as $index => $loft)
                    <div class="flex justify-between items-center text-xs p-2 {{ $index % 2 === 0 ? 'bg-slate-800' : 'bg-slate-950' }} rounded">
                        <div class="truncate">
                            <span class="font-bold text-yellow-500 w-8 inline-block">#{{ $index + 1 }}</span>
                            <a href="{{ route('loft.view', ['loftId' => \App\Models\Loft::where('name', $loft['name'])->first()->id]) }}" class="font-medium text-indigo-400 hover:text-yellow-400 hover:underline">
                                {{ $loft['name'] }}
                            </a>
                            <span class="text-[10px] text-slate-500">Lv. {{ $loft['level'] }}</span>
                        </div>
                        <span class="font-black text-yellow-500">{{ number_format($loft['score'], 1) }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
