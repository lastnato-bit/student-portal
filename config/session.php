<?php

use Illuminate\Support\Str;

return [

    'driver' => env('SESSION_DRIVER', 'database'),

    'lifetime' => (int) env('SESSION_LIFETIME', 120), // ⏱ 15 minutes idle timeout

    'expire_on_close' => env('SESSION_EXPIRE_ON_CLOSE', true), // ✅ logout on browser close

    'encrypt' => env('SESSION_ENCRYPT', false),

    'files' => storage_path('framework/sessions'),

    'connection' => env('SESSION_CONNECTION'),

    'table' => env('SESSION_TABLE', 'sessions'),

    'store' => env('SESSION_STORE'),

    'lottery' => [2, 100],

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),

    'path' => env('SESSION_PATH', '/'),

    'domain' => env('SESSION_DOMAIN'),

    'secure' => env('SESSION_SECURE_COOKIE', true), // ✅ HTTPS only

    'http_only' => env('SESSION_HTTP_ONLY', true),  // ✅ JS can't access session

    'same_site' => env('SESSION_SAME_SITE', 'strict'), // ✅ Strict CSRF protection

    'partitioned' => env('SESSION_PARTITIONED_COOKIE', false),
];
