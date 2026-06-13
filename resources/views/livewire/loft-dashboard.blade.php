<div class="p-6 bg-black min-h-screen text-slate-200">
    @if (session()->has('message'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-4 right-4 z-50 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('message') }}
        </div>
    @endif

    @if (session()->has('error'))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" class="fixed top-4 right-4 z-50 bg-red-600 text-white px-6 py-3 rounded-lg shadow-lg">
            {{ session('error') }}
        </div>
    @endif

    @if($showCreateForm)
        <div class="max-w-md mx-auto bg-slate-900 rounded-2xl shadow-xl p-8 border border-yellow-600">
            <h2 class="text-3xl font-black text-white mb-2">Establish Loft</h2>
            <p class="text-slate-400 mb-6">Welcome, Trainer. Give your new loft a name to begin your journey to the top.</p>
            <form wire:submit.prevent="createLoft">
                <input wire:model="loftName" class="w-full bg-slate-800 border-none rounded-lg p-4 mb-4 text-white focus:ring-2 focus:ring-yellow-500" type="text" placeholder="e.g. Skyline Champions">
                @error('loftName') <span class="text-red-500 text-sm mb-4 block">{{ $message }}</span> @enderror
                <button type="submit" class="w-full bg-yellow-500 text-black font-bold py-4 rounded-lg hover:bg-yellow-400 transition">Create Your Loft</button>
            </form>
        </div>
    @elseif($loft)
        <div class="max-w-7xl mx-auto">
            <!-- Header -->
            @php
                $nextLevel = $loft->level + 1;
                $xpRequired = $nextLevel * $nextLevel * 100;
                $cost = $nextLevel * 500;
                $progress = min(100, ($loft->xp / $xpRequired) * 100);
            @endphp
            <div class="bg-yellow-500 text-black p-8 rounded-3xl shadow-2xl mb-8 flex flex-col md:flex-row justify-between items-center gap-6">
                <div>
                    <h1 class="text-4xl font-black">{{ $loft->name }}</h1>
                    <p class="text-black/70 font-bold mt-1">Loft Level: <span class="text-black">{{ $loft->level }}</span></p>
                    
                    <div class="mt-4 flex items-center gap-4">
                        <div class="w-48 bg-black/20 rounded-full h-2">
                            <div class="bg-black h-2 rounded-full" style="width: {{ $progress }}%"></div>
                        </div>
                        <span class="text-xs font-black">{{ $loft->xp }} / {{ $xpRequired }} XP</span>
                        
                        @if($loft->xp >= $xpRequired && $loft->coins >= $cost)
                            <button wire:click="upgrade" class="bg-black text-yellow-500 text-xs font-bold px-4 py-2 rounded-lg hover:bg-slate-800 transition">
                                Upgrade Loft ({{ number_format($cost) }} 💰)
                            </button>
                        @endif
                    </div>
                </div>
                <div class="flex gap-8">
                    <div class="text-center">
                        <div class="text-4xl font-black text-black">{{ number_format($loft->coins) }}</div>
                        <div class="text-xs uppercase tracking-widest text-black/70 font-bold">Coins</div>
                    </div>
                </div>
            </div>

            <!-- Pigeon Management -->
            <div class="bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-700">
                <h2 class="text-2xl font-black text-white mb-6 flex items-center gap-2">
                    <span class="text-3xl">🕊️</span> Your Pigeons
                </h2>
                <livewire:pigeon-manager />
            </div>
        </div>
    @endif
</div>
