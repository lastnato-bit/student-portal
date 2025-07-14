<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>

    {{-- ✅ Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-white min-h-screen text-gray-800"
      x-data="{
        tab: 'dashboard',
        userMenu: false,
        sidebarOpen: true
      }">
<div class="flex h-screen">

    <!-- Sidebar -->
    <aside class="bg-gradient-to-b from-blue-100 to-white shadow-xl w-64 transition-all duration-200 ease-in-out h-full fixed lg:relative z-40"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">
        <div class="h-full p-6 overflow-y-auto">
            {{-- ✅ Sidebar Logo --}}
            <a href="{{ route('student.dashboard') }}" class="flex items-center space-x-2 mb-6 px-2">
                <img src="{{ asset('logo.png') }}" alt="Student Portal Logo" class="h-10 w-auto">
            </a>

            <ul class="space-y-2 text-[15px] font-medium">
                <li><button @click="tab = 'dashboard'" :class="tab === 'dashboard' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📊 Dashboard</button></li>
                <li><button @click="tab = 'grades'" :class="tab === 'grades' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📚 Grades</button></li>
                <li><button @click="tab = 'schedule'" :class="tab === 'schedule' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🗓️ Schedule</button></li>
                <li><button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">👤 Profile</button></li>
                <li><button @click="tab = 'logs'" :class="tab === 'logs' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📝 Activity Logs</button></li>
                <li><button @click="tab = 'report'" :class="tab === 'report' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📄 Grade Report</button></li>
                <li><button @click="tab = 'holidays'" :class="tab === 'holidays' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🎉 Holidays</button></li>
                <li><button @click="tab = 'enrollment'" :class="tab === 'enrollment' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🧾 Enrollment Info</button></li>
                <li><button @click="tab = 'announcements'" :class="tab === 'announcements' ? 'bg-blue-200 text-blue-700' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📢 Announcements</button></li>
            </ul>
        </div>
    </aside>

    <!-- Content Wrapper -->
    <div class="flex-1 flex flex-col transition-all duration-300 ease-in-out"
         :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">

        <!-- Header -->
        <header class="bg-white shadow-md px-6 py-4 flex justify-between items-center border-b">
            <div class="flex items-center space-x-4">
                <!-- Hamburger -->
                <button class="text-gray-600 focus:outline-none" @click="sidebarOpen = !sidebarOpen">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                <a href="{{ route('student.dashboard') }}" class="text-xl font-semibold tracking-wide text-blue-900 hover:underline">
                    Student Portal
                </a>
            </div>

            <!-- User Dropdown -->
            <div class="relative" @click.away="userMenu = false">
                <button @click="userMenu = !userMenu" class="flex items-center text-sm focus:outline-none hover:text-blue-600 transition">
                    <span class="mr-2 font-medium">{{ Auth::user()->name }}</span>
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div x-show="userMenu" x-transition class="absolute right-0 mt-2 w-48 bg-white border rounded-md shadow-lg z-50">
                    <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm hover:bg-gray-100">👤 Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">🚪 Logout</button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 p-6 overflow-y-auto bg-gray-50">
            <div x-show="tab === 'dashboard'">
                <h2 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600">Use the sidebar to navigate through your academic info and tools.</p>
            </div>
            <div x-show="tab === 'grades'">
                <div class="mb-4 text-right">
                    <a href="{{ route('student.grades.pdf') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition">📥 Download PDF</a>
                </div>
                @livewire('student.grades')
            </div>
            <div x-show="tab === 'schedule'">
                <h2 class="text-xl font-semibold mb-2">🗓️ Schedule</h2>
                @livewire('student.schedule')
            </div>
            <div x-show="tab === 'profile'">@livewire('student.profile')</div>
            <div x-show="tab === 'logs'">@livewire('student.activity-logs')</div>
            <div x-show="tab === 'report'">
                <h2 class="text-xl font-semibold mb-2">📄 Grade Report</h2>
                @livewire('student.grade-report')
            </div>
            <div x-show="tab === 'holidays'">
                <h2 class="text-xl font-semibold mb-2">🎉 Holidays</h2>
                @livewire('student.holidays')
            </div>
            <div x-show="tab === 'enrollment'">@livewire('student.enrollment-info')</div>
            <div x-show="tab === 'announcements'">
                <h2 class="text-xl font-semibold mb-2">📢 Announcements</h2>
                @php
                    $announcements = \App\Models\Announcement::whereIn('visible_to', ['student', 'all'])->orderByDesc('published_at')->get();
                @endphp
                @forelse ($announcements as $announcement)
                    <div class="bg-white p-4 rounded shadow mb-3">
                        <h3 class="text-lg font-bold">{{ $announcement->title }}</h3>
                        <p class="text-gray-600 text-sm mb-2">{{ \Carbon\Carbon::parse($announcement->published_at)->format('F d, Y') }}</p>
                        <p class="text-gray-700">{{ $announcement->content }}</p>
                    </div>
                @empty
                    <p class="text-gray-600">No announcements available.</p>
                @endforelse
            </div>
        </main>
    </div>
</div>
</body>
</html>
