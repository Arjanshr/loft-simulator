<div class="p-6">
    @if (session()->has('message'))
        <div class="bg-green-600 text-white p-4 rounded-lg mb-4">
            {{ session('message') }}
        </div>
    @endif

    <div class="bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-700 mb-8">
        <h2 class="text-2xl font-black text-white mb-6">Game Settings</h2>
        
        <form wire:submit="updateSettings" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($settings as $key => $value)
                <div>
                    <label class="block text-slate-400 text-sm font-bold mb-2 uppercase">{{ str_replace('_', ' ', $key) }}</label>
                    <input wire:model="settings.{{ $key }}" type="number" class="w-full bg-slate-800 border-slate-700 rounded-lg p-3 text-white">
                </div>
            @endforeach
            <button type="submit" class="bg-yellow-500 text-black font-bold px-6 py-3 rounded-lg hover:bg-yellow-400 transition shadow-lg col-span-1 md:col-span-2">
                Save Settings
            </button>
        </form>
    </div>

    <div class="bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-700">
        <h2 class="text-2xl font-black text-white mb-6">Maintenance Actions</h2>
        
        <div class="flex items-center gap-4 p-4 bg-slate-800 rounded-lg border border-slate-700">
            <button wire:click="runMaturation" class="bg-indigo-600 text-white font-bold px-6 py-3 rounded-lg hover:bg-indigo-700 transition shadow-lg shadow-indigo-500/20">
                Run Pigeon Maturation Now
            </button>
            <span class="text-sm text-slate-400">Triggers the hourly maturation process manually.</span>
        </div>
    </div>
</div>
