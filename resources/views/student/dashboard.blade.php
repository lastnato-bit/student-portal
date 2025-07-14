<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Student Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100 min-h-screen text-gray-800" x-data="{ tab: 'dashboard', userMenu: false }">

    <!-- Top Bar -->
    <nav class="bg-white shadow-md px-6 py-4 flex justify-between items-center border-b">
        <h1 class="text-2xl font-semibold tracking-wide">🎓 Student Portal</h1>

        <!-- User Menu -->
        <div class="relative" @click.away="userMenu = false">
            <button @click="userMenu = !userMenu" class="flex items-center text-sm focus:outline-none hover:text-blue-600 transition">
                <span class="mr-2 font-medium">{{ Auth::user()->name }}</span>
                <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
    </nav>

    <!-- Main Layout -->
    <div class="flex h-[calc(100vh-72px)]">
        <!-- Sidebar -->
        <aside class="w-64 bg-white border-r shadow-sm p-4 space-y-2">
            <ul class="space-y-1 text-[15px] font-medium">
                <li><button @click="tab = 'dashboard'" :class="tab === 'dashboard' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📊 Dashboard</button></li>
                <li><button @click="tab = 'grades'" :class="tab === 'grades' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📚 Grades</button></li>
                <li><button @click="tab = 'schedule'" :class="tab === 'schedule' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🗓️ Schedule</button></li>
                <li><button @click="tab = 'profile'" :class="tab === 'profile' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">👤 Profile</button></li>
                <li><button @click="tab = 'logs'" :class="tab === 'logs' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📝 Activity Logs</button></li>
                <li><button @click="tab = 'report'" :class="tab === 'report' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📄 Grade Report</button></li>
                <li><button @click="tab = 'holidays'" :class="tab === 'holidays' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🎉 Holidays</button></li>
                <li><button @click="tab = 'enrollment'" :class="tab === 'enrollment' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">🧾 Enrollment Info</button></li>
                <li><button @click="tab = 'announcements'" :class="tab === 'announcements' ? 'bg-blue-100 text-blue-600' : 'hover:text-blue-600'" class="w-full text-left px-3 py-2 rounded">📢 Announcements</button></li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 bg-gray-50 overflow-y-auto">

            <!-- Dashboard -->
            <div x-show="tab === 'dashboard'">
                <h2 class="text-2xl font-bold mb-2">Welcome, {{ Auth::user()->name }}!</h2>
                <p class="text-gray-600">Use the sidebar to navigate through your academic info and tools.</p>
            </div>

            <!-- Grades -->
            <div x-show="tab === 'grades'">
                <h2 class="text-xl font-semibold mb-4">📚 My Grades</h2>
                <table class="w-full bg-white rounded shadow-sm text-sm">
                    <thead class="bg-gray-100 text-gray-600 uppercase text-xs">
                        <tr>
                            <th class="px-4 py-2">Subject</th>
                            <th class="px-4 py-2">Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-t">
                            <td class="px-4 py-2">Math</td>
                            <td class="px-4 py-2">90</td>
                        </tr>
                        <tr class="border-t">
                            <td class="px-4 py-2">Science</td>
                            <td class="px-4 py-2">88</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Schedule -->
            <div x-show="tab === 'schedule'">
                <h2 class="text-xl font-semibold mb-2">🗓️ Schedule</h2>
                <p class="text-gray-600">Your weekly class schedule will appear here.</p>
            </div>

            <!-- Profile -->
            <div x-show="tab === 'profile'">
                <h2 class="text-xl font-semibold mb-2">👤 Profile</h2>
                <p class="text-gray-600">Your profile information goes here.</p>
            </div>

            <!-- Activity Logs -->
            <div x-show="tab === 'logs'">
                <h2 class="text-xl font-semibold mb-2">📝 Activity Logs</h2>
                <p class="text-gray-600">Recent login and activity logs will be listed here.</p>
            </div>

            <!-- Grade Report -->
            <div x-show="tab === 'report'">
                <h2 class="text-xl font-semibold mb-2">📄 Grade Report</h2>
                <p class="text-gray-600">Printable or downloadable grade reports will be here.</p>
            </div>

            <!-- Holidays -->
            <div x-show="tab === 'holidays'">
                <h2 class="text-xl font-semibold mb-2">🎉 Holidays</h2>
                <p class="text-gray-600">Upcoming school holidays and events will appear here.</p>
            </div>

            <!-- Enrollment Info -->
            <div x-show="tab === 'enrollment'">
                <h2 class="text-xl font-semibold mb-2">🧾 Enrollment Info</h2>
                <p class="text-gray-600">Details about your current enrollment, status, and section.</p>
            </div>

            <!-- Announcements -->
            <div x-show="tab === 'announcements'">
                <h2 class="text-xl font-semibold mb-2">📢 Announcements</h2>
                <p class="text-gray-600">Important announcements and news will be displayed here.</p>
            </div>
        </main>
    </div>

</body>
</html>
