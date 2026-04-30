<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $salesPage->product_name }}</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>

@php
    $themes = [
        'professional' => [
            'bg_main' => 'bg-gray-50',
            'hero' => 'from-blue-600 to-indigo-800 text-white',
            'btn_hero' => 'bg-white text-blue-700',
            'card' => 'bg-white border-gray-100',
            'text_title' => 'text-gray-900',
            'accent' => 'text-blue-600',
            'benefit_card' => 'bg-white border-gray-100',
            'advantage_box' => 'bg-indigo-50 border-indigo-100',
            'advantage_title' => 'text-indigo-900',
            'advantage_text' => 'text-indigo-700',
            'btn_cta' => 'bg-blue-600 text-white',
            'price_text' => 'text-gray-900'
        ],
        'midnight' => [
            'bg_main' => 'bg-gray-950',
            'hero' => 'from-gray-900 to-black text-amber-400 border border-gray-800',
            'btn_hero' => 'bg-amber-400 text-black',
            'card' => 'bg-gray-900 border-gray-800',
            'text_title' => 'text-white',
            'accent' => 'text-amber-400',
            'benefit_card' => 'bg-gray-900 border-gray-800',
            'advantage_box' => 'bg-black border-gray-800',
            'advantage_title' => 'text-amber-400',
            'advantage_text' => 'text-amber-200/90',
            'btn_cta' => 'bg-amber-500 text-black',
            'price_text' => 'text-amber-400'
        ],
        'minimalist' => [
            'bg_main' => 'bg-white',
            'hero' => 'bg-white text-gray-900 border-b border-gray-100',
            'btn_hero' => 'bg-black text-white',
            'card' => 'bg-white border-gray-200',
            'text_title' => 'text-gray-900',
            'accent' => 'text-black',
            'benefit_card' => 'bg-white border-gray-200',
            'advantage_box' => 'bg-gray-50 border-gray-100',
            'advantage_title' => 'text-gray-900',
            'advantage_text' => 'text-gray-600',
            'btn_cta' => 'bg-black text-white',
            'price_text' => 'text-gray-900'
        ]
    ];

    $theme = $themes[$salesPage->template] ?? $themes['professional'];
@endphp

<body class="{{ $theme['bg_main'] }} antialiased transition-all duration-500">

<div class="max-w-6xl mx-auto px-6 py-14">

    <!-- HERO -->
    <div class="bg-gradient-to-br {{ $theme['hero'] }} rounded-[3rem] p-20 text-center shadow-2xl">
        <h1 class="text-6xl font-black mb-6 leading-tight">
            {{ $content['headline'] ?? 'Headline Pending...' }}
        </h1>

        <p class="text-2xl opacity-80 mb-12 max-w-3xl mx-auto leading-relaxed">
            {{ $content['subheadline'] ?? '' }}
        </p>

        <a href="#pricing"
           class="inline-block {{ $theme['btn_hero'] }} px-10 py-5 rounded-2xl font-black text-xl shadow-xl uppercase tracking-wider">
            {{ $content['cta'] ?? 'Buy Now' }}
        </a>
    </div>

    <!-- BENEFITS -->
    <div class="mt-24">
        <h2 class="text-3xl font-black {{ $theme['text_title'] }} text-center uppercase tracking-widest mb-16">
            Why Choose Us?
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse(array_slice($content['benefits'] ?? [], 0, 3) as $benefit)
                <div class="{{ $theme['benefit_card'] }} rounded-[2rem] shadow-xl p-10 text-center border">
                    <div class="w-16 h-16 {{ $theme['accent'] }} bg-opacity-10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-8 h-8 {{ $theme['accent'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path d="M5 13l4 4L19 7" stroke-width="3"/>
                        </svg>
                    </div>

                    <h3 class="text-xl font-black {{ $theme['text_title'] }}">
                        {{ $benefit }}
                    </h3>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-400 italic">
                    No benefits generated yet.
                </p>
            @endforelse
        </div>
    </div>

    <!-- ADVANTAGE -->
    <div class="mt-20 {{ $theme['advantage_box'] }} rounded-[3rem] p-12 border flex flex-col md:flex-row items-center gap-10">
        <div class="flex-1 text-center md:text-left">
            <h2 class="text-3xl font-black {{ $theme['advantage_title'] }} mb-4 italic">
                The {{ $salesPage->product_name }} Advantage
            </h2>

            <p class="text-xl {{ $theme['advantage_text'] }} leading-relaxed font-medium italic">
                "{{ $salesPage->unique_selling_points }}"
            </p>
        </div>
    </div>

    <!-- PRICING -->
    <div id="pricing" class="{{ $theme['card'] }} rounded-[3rem] shadow-2xl p-16 mt-20 text-center border">
        <div class="max-w-2xl mx-auto">

            <p class="{{ $theme['accent'] }} font-black uppercase tracking-[0.2em] text-sm mb-6">
                {{ $content['social_proof'] ?? 'Limited Time Offer' }}
            </p>

            <h2 class="text-4xl font-black {{ $theme['text_title'] }} mb-10 italic">
                "The best investment for your business growth."
            </h2>

            <div class="text-7xl font-black {{ $theme['price_text'] }} mb-12">
                {{ $formattedPrice }}
            </div>

            <button class="{{ $theme['btn_cta'] }} px-16 py-6 rounded-2xl font-black text-2xl shadow-2xl uppercase tracking-widest">
                {{ $content['cta'] ?? 'Get Started Now' }}
            </button>

            <p class="mt-8 text-gray-400 text-[10px] uppercase">
                Secure checkout. 100% Satisfaction Guarantee.
            </p>

        </div>
    </div>

</div>
</body>
</html>