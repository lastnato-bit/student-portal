<x-filament::widget>
    <x-filament::card class="bg-gradient-to-r from-white via-gray-100 to-gray-50 shadow-sm border border-gray-200">
        @php
            $role = strtolower(Auth::user()->role);

            $bannerImage = match ($role) {
                'superadmin' => 'images/superadmin-banner.png',
                'admin' => 'images/admin-banner.png',
                'student' => 'images/student-banner.png',
                'instructor' => 'images/instructor-banner.png',
                default => 'images/default-banner.png',
            };

            $roleColors = [
                'superadmin' => 'text-fuchsia-600',
                'admin' => 'text-indigo-600',
                'student' => 'text-emerald-600',
                'instructor' => 'text-orange-600',
            ];

            $roleColor = $roleColors[$role] ?? 'text-gray-700';
        @endphp

        <div class="flex items-center justify-between flex-wrap gap-4 px-6 py-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">
                    👋 Welcome, {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                </h1>
                <p class="text-sm text-gray-600 mt-1">
                    🎓 Role: <span class="font-medium capitalize {{ $roleColor }}">{{ $role }}</span>
                </p>
            </div>
            <div>
                <img src="{{ asset($bannerImage) }}"
                     alt="{{ ucfirst($role) }} Banner"
                     class="w-36 h-auto rounded-lg shadow-lg ring-1 ring-indigo-300">
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
