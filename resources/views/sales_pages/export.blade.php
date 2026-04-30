<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $salesPage->product_name }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', sans-serif; }</style>
</head>
@php
    $themes = [
        'professional' => [
            'bg_main' => 'bg-gray-50',
            'hero' => 'from-blue-600 to-indigo-800 text-white',
            'btn_hero' => 'bg-white text-blue-700',
            'benefit_card' => 'bg-white border-gray-50',
            'icon_bg' => 'bg-blue-50',
            'icon_svg' => 'text-blue-600',
            'text_title' => 'text-gray-900',
            'advantage_box' => 'bg-indigo-50 border-indigo-100',
            'advantage_title' => 'text-indigo-900',
            'advantage_text' => 'text-indigo-700',
            'price_text' => 'text-gray-900',
            'btn_cta' => 'bg-blue-600 text-white'
        ],
        'midnight' => [
            'bg_main' => 'bg-gray-950',
            'hero' => 'from-gray-900 to-black text-amber-400 border border-gray-800',
            'btn_hero' => 'bg-amber-400 text-black',
            'benefit_card' => 'bg-gray-900 border-gray-800',
            'icon_bg' => 'bg-gray-800',
            'icon_svg' => 'text-amber-400',
            'text_title' => 'text-gray-100',
            'advantage_box' => 'bg-black border-gray-800',
            'advantage_title' => 'text-amber-400',
            'advantage_text' => 'text-gray-400',
            'price_text' => 'text-amber-400',
            'btn_cta' => 'bg-amber-500 text-black'
        ],
        'minimalist' => [
            'bg_main' => 'bg-white',
            'hero' => 'bg-white text-gray-900 border-b border-gray-100',
            'btn_hero' => 'bg-black text-white',
            'benefit_card' => 'bg-white border-gray-200',
            'icon_bg' => 'bg-gray-50',
            'icon_svg' => 'text-black',
            'text_title' => 'text-gray-900',
            'advantage_box' => 'bg-gray-50 border-gray-100',
            'advantage_title' => 'text-gray-900',
            'advantage_text' => 'text-gray-600',
            'price_text' => 'text-gray-900',
            'btn_cta' => 'bg-black text-white'
        ]
    ];
    $theme = $themes[$salesPage->template] ?? $themes['professional'];
@endphp
<body class="{{ $theme['bg_main'] }} antialiased transition-all duration-500">
    <div class="max-w-6xl mx-auto px-6 py-20">
        
        <!-- Hero Section -->
        <div class="bg-gradient-to-br {{ $theme['hero'] }} rounded-[3rem] p-16 text-center shadow-2xl relative overflow-hidden">
            <h1 class="text-5xl font-black mb-6 leading-tight">{{ $content['headline'] ?? 'Amazing Product' }}</h1>
            <p class="text-xl opacity-90 mb-10 max-w-2xl mx-auto leading-relaxed">{{ $content['subheadline'] ?? '' }}</p>
            <a href="#pricing" class="inline-block {{ $theme['btn_hero'] }} px-8 py-4 rounded-2xl font-black uppercase tracking-widest shadow-lg">{{ $content['cta'] ?? 'Order Now' }}</a>
        </div>

        <!-- Benefits -->
        <div class="mt-20">
            <h2 class="text-3xl font-black {{ $theme['price_text'] }} text-center mb-12 uppercase tracking-widest">Why Choose Us?</h2>
            <div class="grid md:grid-cols-3 gap-8">
                @isset($content['benefits'])
                    @foreach($content['benefits'] as $benefit)
                        <div class="{{ $theme['benefit_card'] }} p-8 rounded-[2rem] shadow-lg border text-center">
                            <div class="w-16 h-16 {{ $theme['icon_bg'] }} rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 {{ $theme['icon_svg'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <h3 class="font-bold {{ $theme['text_title'] }}">{{ $benefit }}</h3>
                        </div>
                    @endforeach
                @endisset
            </div>
        </div>

        <!-- Advantage -->
        <div class="mt-20 {{ $theme['advantage_box'] }} rounded-[3rem] p-12 border flex flex-col md:flex-row items-center gap-10">
            <div class="flex-1">
                <h2 class="text-3xl font-black {{ $theme['advantage_title'] }} mb-4 italic">{{ $salesPage->product_name }} Advantage</h2>
                <p class="text-xl {{ $theme['advantage_text'] }} leading-relaxed italic">"{{ $salesPage->unique_selling_points }}"</p>
            </div>
        </div>

        <!-- Pricing -->
        <div id="pricing" class="{{ $theme['benefit_card'] }} rounded-[3rem] shadow-2xl p-16 mt-20 text-center border">
            <p class="{{ $theme['icon_svg'] }} font-black uppercase mb-4">{{ $content['social_proof'] ?? 'Offer' }}</p>
            <div class="text-7xl font-black {{ $theme['price_text'] }} mb-10">{{ $formattedPrice }}</div>
            <button class="{{ $theme['btn_cta'] }} px-12 py-5 rounded-2xl font-black text-xl uppercase tracking-widest shadow-xl">{{ $content['cta'] ?? 'Get Started' }}</button>
        </div>

    </div>
</body>
</html>