<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <x-seo />

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|dancing-script:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script async src="https://www.googletagmanager.com/gtag/js?id=G-5SFZ8Q9N7C"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', 'G-5SFZ8Q9N7C');
        </script>
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-100">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div class="mb-6">
                <a href="/" class="inline-flex items-center gap-2 text-lg font-bold text-gray-800 no-underline">
                    <img src="{{ asset('images/logo.svg') }}" alt="senin 💝 davetiyen" class="w-14 h-14 object-contain">
                    <span style="font-family:'Dancing Script',cursive;font-weight:700;font-size:1.5rem"><span style="color:#06b6d4">Senin</span> <span style="color:#ec4899">Davetiyen</span></span>
                </a>
            </div>

            <div class="w-full sm:max-w-md px-8 py-6 bg-white shadow-md rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
