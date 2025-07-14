@extends('layouts.guest')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white shadow-md rounded-md p-8 w-full max-w-md">

        {{-- Logo --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 w-auto">
        </div>

        <h2 class="text-2xl font-bold mb-6 text-center text-fuchsia-700">Reset Your Password</h2>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 mb-4 rounded">
                <ul class="list-disc ml-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.reset.submit') }}">
            @csrf
            <input type="hidden" name="user_id" value="{{ $user->id }}">

            <div class="mb-4">
                <label for="password" class="block font-semibold mb-1">New Password</label>
                <input id="password" type="password" name="password" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500"
                    onkeyup="checkPassword(this.value)">
            </div>

            <div class="mb-4">
                <label for="password_confirmation" class="block font-semibold mb-1">Confirm Password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required
                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-fuchsia-500">
            </div>

            <ul id="password-rules" class="text-sm mb-4 space-y-1 text-gray-600">
                <li id="rule-length">• Minimum 8 characters</li>
                <li id="rule-uppercase">• At least 1 uppercase letter</li>
                <li id="rule-number">• At least 1 number</li>
                <li id="rule-special">• At least 1 special character</li>
            </ul>

            <button type="submit"
                class="w-full bg-fuchsia-600 hover:bg-fuchsia-700 text-white py-2 rounded font-semibold">
                Reset Password
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('login.admin') }}" class="text-sm text-fuchsia-600 hover:underline">Back to Login</a>
        </div>
    </div>
</div>

<script>
    function checkPassword(password) {
        document.getElementById('rule-length').style.color = password.length >= 8 ? 'green' : 'red';
        document.getElementById('rule-uppercase').style.color = /[A-Z]/.test(password) ? 'green' : 'red';
        document.getElementById('rule-number').style.color = /[0-9]/.test(password) ? 'green' : 'red';
        document.getElementById('rule-special').style.color = /[!@#$%^&*(),.?":{}|<>]/.test(password) ? 'green' : 'red';
    }
</script>
@endsection
