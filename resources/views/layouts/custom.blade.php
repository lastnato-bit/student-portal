<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ ucfirst(auth()->user()?->getRoleNames()?->first() ?? 'User') }} | Profile</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100">

    <div class="min-h-screen">
        {{-- Top Navbar --}}
        @include('layouts.partials.custom-navbar')

        {{-- Page Content --}}
        <main class="py-10">
            @yield('content')
        </main>
    </div>

</body>
</html>
