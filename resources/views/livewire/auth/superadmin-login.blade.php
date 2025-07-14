{{-- filepath: resources/views/livewire/auth/superadmin-login.blade.php --}}
<!-- ✅ DEBUG: superadmin-login.blade.php -->


    <form wire:submit.prevent="login" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4 w-full max-w-md">

        {{-- Optional: Add your logo here --}}
        {{-- <img src="/logo.png" alt="Logo" class="mx-auto mb-4 w-24 h-24"> --}}

        <h2 class="text-2xl font-bold mb-4">Superadmin Login</h2>

        {{-- Show all validation errors --}}
        @if ($errors->any())
            <div class="mb-4 text-red-500">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" wire:model.defer="email" required autofocus
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" wire:model.defer="password" required autocomplete="current-password"
                   class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        {{-- ✅ Add Forgot Password link --}}
        <div class="mb-4 text-right">
            <a href="{{$forgotPasswordUrl}}" class="text-sm text-blue-600 hover:underline">
    Forgot Password?
</a>
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" wire:model.defer="remember"
                       class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                Login as Superadmin
            </button>
        </div>
    </form>
</div>
