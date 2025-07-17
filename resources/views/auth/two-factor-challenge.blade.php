<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Two-Factor Authentication | Student Academic Portal</title>
    @vite('resources/css/app.css') {{-- If you're using Laravel Vite --}}
    <style>
        body {
            background: #f9fafb;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            max-width: 430px;
            margin: 80px auto;
            padding: 30px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 6px 25px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .title {
            font-size: 1.3rem;
            font-weight: 600;
            color: #1f2937;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            margin-bottom: 20px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 0.95rem;
        }

        .btn {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            font-weight: 500;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn:hover {
            background-color: #1d4ed8;
        }

        .link {
            margin-top: 12px;
            text-align: center;
        }

        .link a {
            color: #2563eb;
            text-decoration: underline;
            font-size: 0.9rem;
            cursor: pointer;
        }
    </style>
</head>
<body>
<div class="card">
    <div class="logo">
        <img src="{{ asset('logo.png') }}" alt="Student Academic Portal Logo" class="h-14 w-auto mx-auto">
    </div>

    <div class="title">
        Two-Factor Authentication Required
    </div>

    @if ($errors->any())
        <div style="color: red; font-size: 0.9rem; margin-bottom: 10px;">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('two-factor.login') }}" x-data="{ recovery: false }">
        @csrf

        <div x-show="!recovery">
            <label for="code">Authentication Code</label>
            <input class="form-control" id="code" name="code" type="text" inputmode="numeric" autofocus autocomplete="one-time-code">
        </div>

        <div x-show="recovery" x-cloak>
            <label for="recovery_code">Recovery Code</label>
            <input class="form-control" id="recovery_code" name="recovery_code" type="text" autocomplete="one-time-code">
        </div>

        <button type="submit" class="btn">Log in</button>

        <div class="link">
            <a x-show="!recovery" @click.prevent="recovery = true">Use a recovery code</a>
            <a x-show="recovery" @click.prevent="recovery = false" x-cloak>Use authentication code</a>
        </div>
    </form>
</div>

<script src="https://unpkg.com/alpinejs" defer></script>
</body>
</html>
