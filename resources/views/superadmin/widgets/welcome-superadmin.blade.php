<x-filament::widget>
    <x-filament::card class="bg-gradient-to-r from-white to-gray-100 shadow-sm border border-gray-200">
        <div class="flex items-center justify-between flex-wrap gap-4 px-4 py-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    👋 Welcome, {{ Auth::user()->name }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    🎓 Role: <span class="font-medium capitalize">{{ Auth::user()->role }}</span>
                </p>
            </div>
            <div>
                <img src="{{ asset('images/superadmin-banner.png') }}" alt="Superadmin Banner" class="w-32 h-auto rounded-lg shadow-md">
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
