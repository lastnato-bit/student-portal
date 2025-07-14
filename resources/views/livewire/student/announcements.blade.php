<div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Announcements</h1>

    @forelse ($announcements as $announcement)
        <div class="bg-white rounded shadow p-4 mb-4">
            <h2 class="text-xl font-semibold">{{ $announcement->title }}</h2>
            <p class="text-sm text-gray-600 mb-2">
                {{ \Carbon\Carbon::parse($announcement->published_at)->format('F j, Y') }}
            </p>
            <p>{{ $announcement->content }}</p>
        </div>
    @empty
        <p class="text-gray-500">No announcements available.</p>
    @endforelse
</div>
