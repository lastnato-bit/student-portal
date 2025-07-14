@extends('layouts.app')

@section('content')
<div class="container py-6">
    <h1 class="text-xl font-bold mb-4">Latest Announcements</h1>

    @forelse($announcements as $announcement)
        <div class="border rounded p-4 mb-4 shadow">
            <h2 class="text-lg font-semibold">{{ $announcement->title }}</h2>
            <p class="text-gray-700 mt-2">{{ $announcement->content }}</p>
            <p class="text-sm text-gray-500 mt-1">
                Published on {{ $announcement->published_at ? $announcement->published_at->format('F d, Y') : '—' }}
            </p>
        </div>
    @empty
        <p>No announcements available.</p>
    @endforelse

    {{ $announcements->links() }}
</div>
@endsection
