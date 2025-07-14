<x-filament::widget>
    <x-filament::card class="bg-gradient-to-r from-fuchsia-600 via-pink-500 to-rose-500 text-white shadow-xl border-0">
        <div class="flex items-center justify-between flex-wrap gap-6 px-6 py-8">
            <!-- Welcome Text -->
            <div class="max-w-md">
                <h1 class="text-3xl font-bold leading-tight">
                    👋 Welcome, {{ Auth::user()->name }}
                </h1>
                <p class="mt-2 text-sm font-medium text-pink-100">
                    🧑‍💼 Role: 
                    <span class="capitalize underline decoration-white/30 underline-offset-4">
                        {{ Auth::user()->getRoleNames()->first() ?? 'N/A' }}
                    </span>
                </p>
                <p class="mt-3 text-sm text-pink-200">Here's a quick overview of your system at a glance.</p>
            </div>

            <!-- Banner Image -->
            <div>
                <img src="{{ asset('images/superadmin-banner.png') }}"
                     alt="Superadmin Banner"
                     class="w-36 h-auto rounded-xl shadow-lg ring-2 ring-white/10 hover:scale-105 transition duration-300">
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
