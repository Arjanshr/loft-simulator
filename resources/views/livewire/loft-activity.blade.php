<div class="bg-slate-900 p-8 rounded-3xl shadow-sm border border-slate-700">
    <h2 class="text-2xl font-black text-white mb-6">Activity Log</h2>
    <div class="space-y-3">
        @forelse($activities as $activity)
            <div class="text-xs text-slate-400 border-b border-slate-700 pb-2">
                <span class="text-yellow-500 font-bold">{{ $activity->created_at->diffForHumans() }}</span>
                <span class="text-white">{{ $activity->description }}</span>
            </div>
        @empty
            <p class="text-slate-500 text-sm italic">No recent activity.</p>
        @endforelse
    </div>
</div>
