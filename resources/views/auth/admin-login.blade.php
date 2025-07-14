<div class="w-full max-w-md mx-auto py-12">
    {{-- ✅ Logo Header --}}
    <div class="flex justify-center mb-6">
        <img src="{{ asset('logo.png') }}" alt="Student Academic Portal Logo" class="h-14 w-auto" />
    </div>

    {{-- ✅ Superadmin Login Form --}}
    <form wire:submit.prevent="login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>

        {{-- ✅ Validation Errors --}}
        @if ($errors->any())
            <div class="mb-4 text-red-500 text-sm">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        {{-- ✅ Email --}}
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input
                type="email"
                wire:model.defer="email"
                autocomplete="username"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
        </div>

        {{-- ✅ Password --}}
        <div class="mb-2">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input
                type="password"
                wire:model.defer="password"
                autocomplete="current-password"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            />
        </div>

        {{-- ✅ Google reCAPTCHA --}}
        <div class="mb-4" x-data x-init="
            window.recaptchaCallback = function(token) {
                console.log('Token from Google:', token); // ✅ For debugging
                Livewire.dispatch('recaptchaCompleted', { token });
            };
        ">
            <div
                class="g-recaptcha"
                data-sitekey="{{ config('services.nocaptcha.sitekey') }}"
                data-callback="recaptchaCallback"
                wire:ignore>
            </div>
            @error('recaptchaToken')
                <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- ✅ Forgot password --}}
        <div class="mb-6 text-right">
            <a href="{{ route('admin.password.request') }}" class="text-sm text-indigo-600 hover:underline">
                Forgot your password?
            </a>
        </div>

        {{-- ✅ Submit --}}
        <div class="flex items-center justify-between mb-4">
            <button
                type="submit"
                class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded w-full focus:outline-none focus:shadow-outline">
                Login
            </button>
        </div>

       

{{-- ✅ Include reCAPTCHA script --}}
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
