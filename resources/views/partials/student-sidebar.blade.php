<a href="#" class="flex items-center space-x-2 mb-6">
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
