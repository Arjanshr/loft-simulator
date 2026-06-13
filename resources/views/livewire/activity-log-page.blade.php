<div class="p-6 max-w-4xl mx-auto">
    <div class="bg-slate-900 p-8 rounded-2xl shadow-sm border border-slate-700">
        <h2 class="text-2xl font-black text-white mb-6">Activity Log</h2>
        <div class="space-y-3">
            @forelse($activities as $activity)
                <div class="flex justify-between items-center text-sm border-b border-slate-700 pb-3">
                    <span class="text-white">{{ $activity->description }}</span>
                    <span class="text-yellow-500 font-bold text-xs">{{ $activity->created_at->diffForHumans() }}</span>
                </div>
            @empty
                <p class="text-slate-500 text-sm italic">No recent activity.</p>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $activities->links() }}
        </div>
    </div>
</div>
