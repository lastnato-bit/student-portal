@extends('layouts.custom')

@php
    $role = auth()->user()?->getRoleNames()?->first() ?? 'guest';
@endphp

@section('content')
<div class="max-w-7xl mx-auto px-4 space-y-10">

    {{-- ✅ Welcome Header --}}
    <div class="flex items-center justify-between flex-wrap gap-4 mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">👤 Profile Settings</h1>
            <p class="text-sm text-gray-600 dark:text-gray-300">
                Manage your account preferences, security, and personal details.
            </p>
        </div>
        <a href="{{ url('/dashboard') }}"
           class="inline-flex items-center px-4 py-2 
           @if($role === 'superadmin') bg-fuchsia-600 hover:bg-fuchsia-500
           @elseif($role === 'admin') bg-amber-600 hover:bg-amber-500
           @else bg-blue-600 hover:bg-blue-500 @endif
           text-white text-xs font-bold rounded-md transition">
            ← Back to Dashboard
        </a>
    </div>

    {{-- ✅ Role-Specific Banner --}}
    <div class="p-6 rounded-lg shadow bg-gradient-to-r 
        @if($role === 'superadmin') from-fuchsia-600 to-pink-500
        @elseif($role === 'admin') from-amber-500 to-yellow-400
        @else from-blue-600 to-indigo-500
        @endif text-white">
        <h2 class="text-xl font-semibold">
            {{ ucfirst($role) }} Settings
        </h2>
        <p class="text-sm opacity-90 mt-1">
            @if($role === 'superadmin')
                You have full access to manage system-wide settings, admins, and security.
            @elseif($role === 'admin')
                You manage users, platform content, and enrollment information.
            @else
                You manage your personal account, password, and security options.
            @endif
        </p>
    </div>

    {{-- ✅ Profile Info --}}
    @if (Laravel\Fortify\Features::canUpdateProfileInformation())
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📄 Update Profile Information</h3>
            @livewire('profile.update-profile-information-form')
        </div>
    @endif

    {{-- ✅ Update Password --}}
    @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">🔐 Update Password</h3>
            @livewire('profile.update-password-form')
        </div>
    @endif

    {{-- ✅ 2FA --}}
    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">📱 Two-Factor Authentication</h3>
            @livewire('profile.two-factor-authentication-form')
        </div>
    @endif

    {{-- ✅ Browser Sessions --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-gray-200 dark:border-gray-700">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4">💻 Active Browser Sessions</h3>
        @livewire('profile.logout-other-browser-sessions-form')
    </div>

    {{-- ✅ Delete Account --}}
    @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md border border-red-300 dark:border-red-500">
            <h3 class="text-lg font-semibold text-red-600 dark:text-red-400 mb-4">⚠️ Delete Account</h3>
            @livewire('profile.delete-user-form')
        </div>
    @endif

</div>
@endsection
