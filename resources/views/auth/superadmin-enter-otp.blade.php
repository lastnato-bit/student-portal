@extends('layouts.auth')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-center">Enter OTP</h2>

    @if(session('status'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('superadmin.verify-otp.verify', $user->id) }}">
        @csrf

        <div class="mb-4">
            <label for="otp" class="block text-sm font-medium text-gray-700">
                Enter the 6-digit OTP sent to your email
            </label>
            <input id="otp" name="otp" type="text" maxlength="6" required autofocus
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:ring-indigo-500 focus:border-indigo-500"
                   placeholder="e.g. 123456"
                   value="{{ old('otp') }}">
        </div>

        <div>
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Verify OTP
            </button>
        </div>
    </form>
@endsection
