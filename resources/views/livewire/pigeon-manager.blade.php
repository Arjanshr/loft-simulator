<div>
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-4 right-4 z-50 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-4 right-4 z-50 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-4">
        @foreach($pigeons as $pigeon)
            <div class="border rounded-lg p-4 bg-gray-50">
                <div class="flex justify-between items-start mb-2">
                    <div>
                        <h3 class="font-bold text-lg">{{ $pigeon->name }}</h3>
                        <span class="text-xs text-gray-500 uppercase font-bold">{{ $pigeon->status }}</span>
                    </div>
                    <div class="text-right">
                        <div class="text-sm font-medium">⚡ Energy: {{ $pigeon->energy }}%</div>
                        <div class="w-24 bg-gray-200 rounded-full h-1.5 mt-1">
                            <div class="bg-yellow-400 h-1.5 rounded-full" style="width: {{ $pigeon->energy }}%"></div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-4">
                    @foreach(['speed' => '🏃', 'endurance' => '🔋', 'navigation' => '🧭', 'temperament' => '🧘'] as $stat => $icon)
                        <div class="bg-white p-2 rounded border">
                            <div class="flex justify-between text-xs mb-1">
                                <span>{{ $icon }} {{ ucfirst($stat) }}</span>
                                <span class="font-bold">{{ $pigeon->$stat }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1 mb-2">
                                <div class="bg-blue-500 h-1 rounded-full transition-all duration-500" style="width: {{ $pigeon->$stat }}%"></div>
                            </div>
                            <button 
                                wire:click="train({{ $pigeon->id }}, '{{ $stat }}')"
                                wire:loading.attr="disabled"
                                class="w-full text-[10px] bg-gray-100 hover:bg-blue-100 text-gray-700 py-1 rounded transition"
                                @if($pigeon->energy < 20 || $pigeon->status !== 'idle') disabled @endif
                            >
                                Train
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
</div>
