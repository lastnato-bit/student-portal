<x-filament::widget>
    <div class="rounded-xl overflow-hidden shadow-xl bg-gradient-to-r from-lime-300 via-lime-200 to-lime-100 border border-lime-400/50">
        <div class="grid grid-cols-1 md:grid-cols-2 items-center gap-6 px-6 py-8">

            {{-- ✅ Left Side: Welcome Text --}}
            <div class="max-w-md text-gray-900">
                <h1 class="text-3xl font-bold leading-tight">
                    👋 Welcome, {{ Auth::user()->firstname }} {{ Auth::user()->middlename }} {{ Auth::user()->lastname }}
                </h1>
                <p class="mt-2 text-sm font-medium text-green-800">
                    🧑‍💼 Role:
                    <span class="capitalize underline decoration-green-700/40 underline-offset-4">
                        {{ Auth::user()->getRoleNames()->first() ?? 'N/A' }}
                    </span>
                </p>
                <p class="mt-3 text-sm text-green-700">
                    Here's a quick overview of your system at a glance.
                </p>
            </div>

            {{-- ✅ Right Side: Icon or Visual --}}
            <div class="flex justify-center md:justify-end">
                <div class="text-[5rem] opacity-80">📈</div>
            </div>

        </div>
    </div>
</x-filament::widget>
