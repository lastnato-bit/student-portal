@extends('layouts.simple') {{-- ✅ not layouts.app --}}

@section('content')
    <h2 class="text-lg font-bold mb-4">Change Your Password</h2>

    <form method="POST" action="{{ route('admin.force-password-change.submit') }}">
        @csrf

        <div class="mb-4">
            <label for="password" class="block text-sm font-medium">New Password</label>
            <input id="password" name="password" type="password" required class="w-full border px-3 py-2 rounded">
        </div>

        <div class="mb-4">
            <label for="password_confirmation" class="block text-sm font-medium">Confirm Password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">
            Save New Password
        </button>
    </form>
@endsection
