@extends('layouts.simple')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-2xl font-bold mb-4">Change Your Password</h2>

    @if(session('status'))
        <div class="text-green-600 mb-2">{{ session('status') }}</div>
    @endif

    @if(session('error'))
        <div class="text-red-600 mb-2">{{ session('error') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.force-password-change.update') }}">
        @csrf

        {{-- ✅ New Password Field --}}
        <div class="mb-4">
            <label for="password" class="block mb-1 font-semibold">New Password</label>
            <input
                type="password"
                name="password"
                id="password"
                required
                class="w-full border rounded px-3 py-2 @error('password') border-red-500 @enderror"
            >
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ✅ Confirm Password Field --}}
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-1 font-semibold">Confirm Password</label>
            <input
                type="password"
                name="password_confirmation"
                id="password_confirmation"
                required
                class="w-full border rounded px-3 py-2"
            >
        </div>

        {{-- ✅ Submit --}}
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
            Update Password
        </button>
    </form>
</div>
@endsection
