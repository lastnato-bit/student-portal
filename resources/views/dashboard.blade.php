<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 text-gray-800">
                    You're logged in as a <strong>Student</strong>! 🎓<br>
                    This is your dashboard. Customize it for announcements, modules, or grades.
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
