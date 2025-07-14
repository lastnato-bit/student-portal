<x-filament::widget>
    <x-filament::card>
        <x-slot name="header">
            <h2 class="text-lg font-bold">Recent Activity Logs</h2>
        </x-slot>

        <ul class="space-y-4">
            @forelse ($logs as $log)
                <li class="text-sm text-gray-700">
                    <strong>{{ $log->causer?->name ?? 'System' }}</strong> -
                    {{ $log->description }} on 
                    <em>{{ $log->subject_type }}</em> 
                    <span class="text-xs text-gray-500">({{ $log->created_at->diffForHumans() }})</span>
                </li>
            @empty
                <li class="text-sm text-gray-500">No recent activities found.</li>
            @endforelse
        </ul>
    </x-filament::card>
</x-filament::widget>
