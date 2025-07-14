@extends('layouts.auth')

@section('content')
    <h2 class="text-2xl font-bold mb-6 text-center">Register New Superadmin</h2>

    @if (session()->has('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4 text-sm text-center">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="register" class="space-y-4">
        {{-- First Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">First Name</label>
            <input type="text" wire:model.defer="firstname"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('firstname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Middle Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Middle Name (optional)</label>
            <input type="text" wire:model.defer="middlename"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('middlename') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Last Name --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Last Name</label>
            <input type="text" wire:model.defer="lastname"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('lastname') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Email --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" wire:model.defer="email"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('email') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" wire:model.defer="password"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
            @error('password') <span class="text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        {{-- Confirm Password --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" wire:model.defer="password_confirmation"
                   class="w-full border border-gray-300 rounded-md px-3 py-2 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
        </div>

        {{-- ✅ Google reCAPTCHA v2 --}}
        <div>
            <div class="g-recaptcha" data-sitekey="{{ config('services.nocaptcha.sitekey') }}"></div>
            @error('g-recaptcha-response')
                <span class="text-sm text-red-600">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Create Superadmin
        </button>
    </form>

    {{-- ✅ Load reCAPTCHA script --}}
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endsection
