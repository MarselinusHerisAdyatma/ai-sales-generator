<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AI Sales Generator</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50">
    <div class="relative min-h-screen flex flex-col items-center justify-center selection:bg-blue-500 selection:text-white">
        
        <!-- Navigation -->
        <div class="fixed top-0 right-0 p-6 text-right z-10">
            @auth
                <a href="{{ url('/dashboard') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-semibold text-gray-600 hover:text-blue-600 transition">Log in</a>
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 font-semibold text-white bg-blue-600 px-6 py-2 rounded-xl hover:bg-blue-700 transition shadow-lg">Get Started</a>
                @endif
            @endauth
        </div>

        <!-- Hero Content -->
        <div class="max-w-4xl mx-auto p-6 text-center">
            <div class="inline-block px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold mb-6">
                ✨ Powered by Gemini AI 2.5
            </div>
            <h1 class="text-6xl font-extrabold text-gray-900 mb-6 leading-tight">
                Turn Raw Ideas Into <span class="text-blue-600">High-Converting</span> Sales Pages
            </h1>
            <p class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                Hasilkan copywriting persuasif, headline menarik, dan struktur landing page profesional dalam hitungan detik. Cukup masukkan detail produk Anda.
            </p>
            
            <div class="flex gap-4 justify-center">
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-blue-700 transition shadow-xl">
                    Mulai Sekarang — Gratis
                </a>
            </div>
        </div>
    </div>
</body>
</html>