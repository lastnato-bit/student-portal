
    
        <h2 class="text-2xl font-bold mb-4 text-center">Admin Login</h2>

        @if ($errors->any())
            <div class="mb-4 text-red-500 text-sm">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input type="email" wire:model.defer="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        <div class="mb-2">
            <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
            <input type="password" wire:model.defer="password" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
        </div>

        {{-- ✅ Forgot Password Link --}}
        <div class="mb-4 text-right">
            <a href="{{ route('admin.password.request') }}" class="text-sm text-blue-600 hover:underline">
                Forgot your password?
            </a>
            <div class="text-red-600 font-bold">
    TESTING DISPLAY
</div>

        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="bg-amber-500 hover:bg-amber-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full">
                Login
            </button>
        </div>
    </form>
</div>
