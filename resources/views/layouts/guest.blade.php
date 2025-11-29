<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-900 via-blue-900 to-gray-900 dark:from-gray-950 dark:via-blue-950 dark:to-gray-950 relative overflow-hidden">
            
            <!-- Background Decoration -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 pointer-events-none">
                <div class="absolute top-[-10%] left-[-10%] w-96 h-96 bg-blue-500/20 rounded-full blur-3xl"></div>
                <div class="absolute bottom-[-10%] right-[-10%] w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl"></div>
            </div>

            <div class="z-10 mb-6">
                <a href="/" class="flex items-center gap-2 text-white">
                    <x-application-logo class="w-20 h-20 fill-current text-white" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-8 bg-white/90 dark:bg-gray-800/90 backdrop-blur-xl shadow-2xl overflow-hidden sm:rounded-2xl border border-white/20 dark:border-gray-700/50 z-10 relative">
                {{ $slot }}
            </div>
            
            <!-- Footer Links -->
            <div class="mt-8 text-center text-sm text-gray-400 z-10">
                <p>&copy; {{ date('Y') }} SpeedJobs Africa. All rights reserved.</p>
            </div>
        </div>
    </body>
</html>
