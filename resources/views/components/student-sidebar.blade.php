<!-- resources/views/components/student-sidebar.blade.php -->
<aside class="w-64 bg-white border-r border-gray-200 shadow-sm">
    <div class="px-6 py-4 border-b text-center">
        <img src="{{ Auth::user()->profile_photo_url }}" class="w-16 h-16 rounded-full mx-auto mb-2" alt="Avatar">
        <h2 class="text-lg font-semibold">{{ Auth::user()->name }}</h2>
        <span class="text-sm text-gray-500">Student</span>
    </div>

    <nav class="mt-4">
        <ul class="space-y-1 text-sm text-gray-700 font-medium">
            <li>
                <a href="{{ route('student.dashboard') }}" class="flex items-center px-6 py-2 hover:bg-blue-100 hover:text-blue-700 rounded-md">
                    <x-lucide-layout-dashboard class="w-5 h-5 mr-3" /> Dashboard
                </a>
            </li>
            <li>
                <a href="{{ route('student.grades') }}" class="flex items-center px-6 py-2 hover:bg-blue-100 hover:text-blue-700 rounded-md">
                    <x-lucide-book class="w-5 h-5 mr-3" /> Grades
                </a>
            </li>
            <li>
                <a href="{{ route('student.schedule') }}" class="flex items-center px-6 py-2 hover:bg-blue-100 hover:text-blue-700 rounded-md">
                    <x-lucide-calendar-days class="w-5 h-5 mr-3" /> Schedule
                </a>
            </li>
            <li>
                <a href="{{ route('student.profile') }}" class="flex items-center px-6 py-2 hover:bg-blue-100 hover:text-blue-700 rounded-md">
                    <x-lucide-user class="w-5 h-5 mr-3" /> Profile
                </a>
            </li>
            <li>
                <a href="{{ route('student.logs') }}" class="flex items-center px-6 py-2 hover:bg-blue-100 hover:text-blue-700 rounded-md">
                    <x-lucide-clipboard-list class="w-5 h-5 mr-3" /> Activity Logs
                </a>
            </li>
            <li>
                <a href="{{ route('student.grade-report') }}" class="flex items-center px-6 py-2 hover:bg-blue-100 hover:text-blue-700 rounded-md">
                    <x-lucide-bar-chart class="w-5 h-5 mr-3" /> Grade Report
                </a>
            </li>
            <li>
                <a href="{{ route('student.holidays') }}" class="flex items-center px-6 py-2 hover:bg-blue-100 hover:text-blue-700 rounded-md">
                    <x-lucide-sun class="w-5 h-5 mr-3" /> Holidays
                </a>
            </li>
        </ul>
    </nav>
</aside>
