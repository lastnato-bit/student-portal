@extends('layouts.guest')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-center">Reset Password</h2>

    @if ($errors->any())
        <div class="mb-4 text-sm text-red-500">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <div class="mb-4">
            <label for="password" class="block text-sm font-bold mb-2 text-gray-700">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-500">
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-bold mb-2 text-gray-700">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring focus:ring-indigo-500">
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Reset Password
            </button>
        </div>
    </form>
@endsection
