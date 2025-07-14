import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './vendor/filament/**/*.blade.php', // ✅ Add Filament Blade components
                // Optional: Vue support
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: {
                    DEFAULT: '#4f46e5', // Indigo-600 (Filament primary)
                    light: '#6366f1',
                    dark: '#4338ca',
                },
                accent: {
                    DEFAULT: '#f59e0b', // Amber-500
                    light: '#fbbf24',
                    dark: '#b45309',
                },
                sidebar: '#1e293b', // Slate-800 for sidebar backgrounds
                body: '#f8fafc',    // Light gray for dashboard background
            },
        },
    },

    darkMode: 'class', // ✅ Enable dark mode support if needed

    plugins: [forms, typography],
};
