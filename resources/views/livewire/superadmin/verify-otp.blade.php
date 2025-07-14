@extends('layouts.auth')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-center">Verify Your Account</h2>

    @if (session('error'))
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4 text-sm text-center">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm text-center">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="verify">
        <div class="mb-4">
            <label for="otp" class="block text-sm font-medium text-gray-700">
                Enter the 6-digit OTP sent to your email
            </label>
            <input type="text" id="otp" wire:model.defer="otp"
                   maxlength="6"
                   class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm px-3 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                   placeholder="e.g. 123456">
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Verify Account
        </button>
    </form>
@endsection
