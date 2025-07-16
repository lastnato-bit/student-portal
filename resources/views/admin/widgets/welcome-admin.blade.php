<x-filament::widget>
    <x-filament::card class="bg-gradient-to-r from-indigo-100 to-white border-l-4 border-indigo-400 shadow-md">
        <div class="flex items-center justify-between flex-wrap gap-4 px-6 py-6">
            {{-- Left Content --}}
            <div class="space-y-2">
                <h1 class="text-3xl font-extrabold text-indigo-700">
                    👋 Welcome, {{ Auth::user()->fullname ?? Auth::user()->name }}
                </h1>
                <p class="text-sm text-indigo-600">
                    🎓 Role:
                    <span class="bg-indigo-200 text-indigo-800 font-semibold px-2 py-0.5 rounded-full">
                        {{ ucfirst(Auth::user()->role) }}
                    </span>
                </p>
            </div>

            {{-- Right Banner Image --}}
            <div>
                <img src="{{ asset('images/admin-banner.png') }}"
                     alt="Welcome Banner"
                     class="w-36 h-auto rounded-lg shadow-lg ring-1 ring-indigo-300">
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
