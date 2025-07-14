@php
    $role = auth()->user()?->getRoleNames()?->first();
@endphp

<nav class="bg-white dark:bg-gray-800 shadow">
    <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
        <div class="flex items-center gap-2 font-bold text-lg">
            @switch($role)
                @case('admin') 🛠️ Admin Panel @break
                @case('superadmin') 🧑‍💻 Superadmin Panel @break
                @case('student') 🎓 Student Portal @break
                @default 👤 User
            @endswitch
        </div>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="text-sm text-red-600 hover:underline">Logout</button>
        </form>
    </div>
</nav>
