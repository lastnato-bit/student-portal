<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Student Academic Portal') }}</title>

    <!-- ✅ Favicon (optional) -->
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-100">

    <!-- ✅ Coded Logo Only (No PNG) -->
    <div class="p-4 bg-white shadow-sm">
        <a href="/superadmin" class="flex items-center space-x-2 no-underline">
            <span class="text-2xl">🎓</span>
            <span class="text-lg font-extrabold text-blue-700 tracking-wide hover:text-blue-900 transition-all duration-200">
                Student Academic Portal
            </span>
        </a>
    </div>

    <!-- Main Content -->
    {{ $slot }}

    @livewireScripts
    @vite('resources/js/app.js')
</
