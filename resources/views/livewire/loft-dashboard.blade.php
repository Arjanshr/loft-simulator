<div class="p-6">
    @if($showCreateForm)
        <div class="max-w-md mx-auto bg-white rounded-xl shadow-md overflow-hidden md:max-w-2xl p-6">
            <h2 class="text-2xl font-bold mb-4">Welcome, Trainer!</h2>
            <p class="mb-4 text-gray-600">Give your new pigeon loft a name to start your journey.</p>
            <form wire:submit.prevent="createLoft">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="loftName">
                        Loft Name
                    </label>
                    <input wire:model="loftName" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="loftName" type="text" placeholder="e.g. Sky High Lofts">
                    @error('loftName') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Establish Loft
                </button>
            </form>
        </div>
    @elseif($loft)
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Header Stats -->
            <div class="md:col-span-3 bg-white p-6 rounded-xl shadow-sm border border-gray-100 flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-black text-gray-800">{{ $loft->name }}</h1>
                    <p class="text-gray-500">Established {{ $loft->created_at->format('M Y') }}</p>
                </div>
                <div class="flex gap-4">
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-yellow-600">💰 {{ number_format($loft->coins) }}</span>
                        <span class="text-xs uppercase text-gray-400 font-semibold">Coins</span>
                    </div>
                    <div class="text-center">
                        <span class="block text-2xl font-bold text-blue-600">⭐ {{ $loft->level }}</span>
                        <span class="text-xs uppercase text-gray-400 font-semibold">Level</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <h2 class="text-xl font-bold mb-4">Your Champions</h2>
                    <livewire:pigeon-manager />
                </div>
            </div>

            <div class="space-y-6">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition-shadow">
                    <h2 class="text-xl font-bold mb-4">Available Races</h2>
                    <livewire:race-lobby />
                </div>
                
                <livewire:race-history-display />
                
                <div class="bg-indigo-600 p-6 rounded-xl shadow-md text-white hover:bg-indigo-700 transition-colors">
                    <h3 class="font-bold text-lg mb-2">Tip of the day</h3>
                    <p class="text-indigo-100 text-sm">Navigation reduces randomness. If your birds are inconsistent, focus on navigation training!</p>
                </div>
            </div>
        </div>
    @endif
</div>
