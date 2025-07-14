@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-semibold mb-6">Create Announcement</h1>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="bg-red-100 text-red-800 p-4 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('announcements.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Title Field --}}
        <div>
            <label for="title" class="block font-medium">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300" required>
        </div>

        {{-- Content Field --}}
        <div>
            <label for="content" class="block font-medium">Content</label>
            <textarea name="content" id="content" rows="5"
                class="w-full border border-gray-300 rounded px-4 py-2 mt-1 focus:outline-none focus:ring focus:border-blue-300"
                required>{{ old('content') }}</textarea>
        </div>

        {{-- Submit Button --}}
        <div>
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
                Post Announcement
            </button>
        </div>
    </form>
</div>
@endsection
