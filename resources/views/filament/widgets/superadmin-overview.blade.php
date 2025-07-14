<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-bold mb-4">Admin Dashboard Overview</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="bg-blue-100 p-4 rounded">
                <p class="text-sm text-gray-600">Total Admins</p>
                <p class="text-xl font-semibold text-blue-900">{{ $totalAdmins }}</p>
            </div>
            <div class="bg-green-100 p-4 rounded">
                <p class="text-sm text-gray-600">Total Students</p>
                <p class="text-xl font-semibold text-green-900">{{ $totalStudents }}</p>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
