{{-- resources/views/auth/superadmin-forgot-password.blade.php --}}
@extends('layouts.auth')

@section('content')
    <form method="POST" action="{{ route('superadmin.password.email') }}">
        @csrf

        <h2 class="text-2xl font-bold mb-6 text-center">Superadmin Forgot Password</h2>

        @if (session('status'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 text-red-500 text-sm">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="mb-4">
            <label for="email" class="block text-sm font-bold mb-2 text-gray-700">Email Address</label>
            <input id="email" type="email" name="email" required autofocus
                   class="w-full border rounded px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-500">
        </div>

        <div class="mt-6">
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Send Confirmation Link
            </button>
        </div>
        
    </form>
@endsection
