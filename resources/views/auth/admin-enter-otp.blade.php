@extends('layouts.auth') {{-- Update this if you're using a custom layout --}}

@section('content')
<div class="container mx-auto max-w-md py-8">
    <h2 class="text-2xl font-bold mb-4 text-center">Enter OTP</h2>

    @if(session('status'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.verify-otp.verify', $user->id) }}">

        @csrf

        <div class="mb-4">
            <label for="otp" class="block text-sm font-medium">Enter the 6-digit OTP sent to your email</label>
            <input id="otp" name="otp" type="text" maxlength="6" required autofocus
                class="w-full mt-1 p-2 border rounded"
                placeholder="e.g. 123456"
                value="{{ old('otp') }}">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white p-2 rounded">
            Verify OTP
        </button>
    </form>
</div>
@endsection
