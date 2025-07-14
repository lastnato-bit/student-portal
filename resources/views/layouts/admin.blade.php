<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin | {{ config('app.name', 'Student Portal') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('styles')
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-white font-sans min-h-screen flex flex-col">

    {{-- Topbar --}}
    <header class="bg-fuchsia-700 text-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold tracking-wide">🎓 Student Portal - Admin</h1>
            <div class="flex items-center gap-4 text-sm">
                <span>{{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button class="text-white hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="flex-1">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-fuchsia-800 text-white text-center py-4 mt-10">
        &copy; {{ date('Y') }} Admin Panel — Student Academic Portal
    </footer>

    @livewireScripts
    @stack('scripts')
</body>
</html>
