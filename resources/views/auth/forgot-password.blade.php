@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-800">Forgot Password</h2>

    @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm text-center">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-600">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4 w-full max-w-md">
        @csrf

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- Submit & Link --}}
        <div class="space-y-3">
            <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-amber-500">
                Send Password Reset Link
            </button>

            <a href="{{ route('login') }}" class="block text-sm text-center text-blue-600 hover:underline">
                Back to Login
            </a>
        </div>
    </form>
@endsection
