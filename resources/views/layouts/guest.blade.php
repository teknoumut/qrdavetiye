<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'senin 💝 davetiyen') }}</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="mb-6">
                <a href="/" class="inline-flex items-center gap-2 text-lg font-bold text-gray-800 no-underline">
                    <span class="w-9 h-9 rounded-lg bg-indigo-500 flex items-center justify-center text-white text-sm font-bold shadow-md">s</span>
                    senin 💝 davetiyen
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-6 bg-white shadow-md rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
