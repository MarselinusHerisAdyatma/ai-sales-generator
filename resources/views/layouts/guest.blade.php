<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SalesGenie') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <!-- Ubah bg-slate-900 jadi bg-gray-50 -->
    <body class="font-sans text-gray-900 antialiased bg-gray-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="/">
                    <!-- Logo kita kasih warna biru primer -->
                    <div class="bg-blue-600 p-3 rounded-2xl shadow-lg shadow-blue-200">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                </a>
            </div>

            <!-- Card Auth: Bikin rounded-3xl dan shadow-xl yang lembut -->
            <div class="w-full sm:max-w-md mt-8 px-8 py-10 bg-white shadow-xl shadow-gray-200/50 overflow-hidden sm:rounded-3xl border border-gray-100">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>