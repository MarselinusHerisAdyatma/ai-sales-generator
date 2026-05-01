<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $salesPage->product_name }}</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700;900&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Syncing custom transitions & animations from show.blade */
        .group:hover .card-hover { transform: scale(1.02); }
        .animate-bounce-slow {
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 100% { transform: translateY(-5%); animation-timing-function: cubic-bezier(0.8, 0, 1, 1); }
            50% { transform: translateY(0); animation-timing-function: cubic-bezier(0, 0, 0.2, 1); }
        }
    </style>
</head>

@php
    // EXACT THEME MATCHING FROM SHOW.BLADE
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
            'btn_cta' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-200'
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
            'btn_cta' => 'bg-amber-500 hover:bg-amber-600 text-black shadow-amber-900/20'
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
            'btn_cta' => 'bg-black hover:bg-gray-800 text-white shadow-xl'
        ]
    ];

    $theme = $themes[$salesPage->template] ?? $themes['professional'];
@endphp

<body class="{{ $theme['bg_main'] }} antialiased transition-colors duration-500 min-h-screen py-14">

    <div class="max-w-6xl mx-auto px-6">
        
        <!-- HERO SECTION (MATCHED) -->
        <div class="bg-gradient-to-br {{ $theme['hero'] }} rounded-[3rem] p-20 text-center shadow-2xl relative overflow-hidden transition-all duration-500">
            <h1 class="text-6xl font-black mb-6 leading-tight relative z-10">
                {{ $content['headline'] ?? 'Headline Pending...' }}
            </h1>
            <p class="text-2xl opacity-80 mb-12 max-w-3xl mx-auto leading-relaxed relative z-10">
                {{ $content['subheadline'] ?? '' }}
            </p>
            <div class="relative z-10">
                <a href="#pricing" 
                   class="inline-block {{ $theme['btn_hero'] }} px-10 py-5 rounded-2xl font-black text-xl shadow-xl transition-transform uppercase tracking-wider">
                    {{ !empty($content['cta']) ? $content['cta'] : 'Buy Now' }}
                </a>
            </div>
        </div>

        <!-- BENEFITS SECTION (MATCHED) -->
        <div class="mt-24">
            <div class="flex flex-col items-center mb-16">
                <h2 class="text-3xl font-black {{ $theme['text_title'] }} uppercase tracking-widest mb-4">
                    Why Choose Us?
                </h2>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                @forelse(array_slice($content['benefits'] ?? [], 0, 3) as $benefit)
                    <div class="{{ $theme['benefit_card'] }} rounded-[2rem] shadow-xl p-10 text-center border transition-all">
                        <div class="w-16 h-16 {{ $theme['accent'] }} bg-opacity-10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 {{ $theme['accent'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-black {{ $theme['text_title'] }}">{{ $benefit }}</h3>
                    </div>
                @empty
                    <p class="col-span-full text-center text-gray-400 italic">No benefits generated yet.</p>
                @endforelse
            </div>
        </div>

        <!-- ADVANTAGE SECTION (MATCHED) -->
        <div class="mt-20 {{ $theme['advantage_box'] }} rounded-[3rem] p-12 border flex flex-col md:flex-row items-center gap-10 transition-all">
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-3xl font-black {{ $theme['advantage_title'] }} mb-4 italic">
                    The {{ $salesPage->product_name }} Advantage
                </h2>
                <p class="text-xl {{ $theme['advantage_text'] }} leading-relaxed font-medium italic">
                    "{{ $salesPage->unique_selling_points }}"
                </p>
            </div>
            <div class="bg-white p-8 rounded-full shadow-2xl animate-bounce-slow hidden md:block">
                <span class="text-5xl">⚡</span>
            </div>
        </div>

        <!-- PRICING SECTION (MATCHED) -->
        <div id="pricing" class="{{ $theme['card'] }} rounded-[3rem] shadow-2xl p-16 mt-20 text-center border transition-all">
            <div class="max-w-2xl mx-auto">
                <p class="{{ $theme['accent'] }} font-black uppercase tracking-[0.2em] text-sm mb-6">
                    {{ !empty($content['social_proof']) ? $content['social_proof'] : 'Limited Time Offer' }}
                </p>
                
                <h2 class="text-4xl font-black {{ $theme['text_title'] }} mb-10 italic leading-snug">
                    "The best investment for your business growth."
                </h2>
                
                <div class="text-7xl font-black {{ $theme['text_title'] }} mb-12 tracking-tighter">
                    {{ $formattedPrice }}
                </div>
                
                <button class="{{ $theme['btn_cta'] }} px-16 py-6 rounded-2xl font-black text-2xl shadow-2xl w-full md:w-auto uppercase tracking-widest transition-all">
                    {{ !empty($content['cta']) ? $content['cta'] : 'Get Started Now' }}
                </button>
                
                <p class="mt-8 text-gray-400 text-[10px] font-medium uppercase tracking-tight">
                    Secure checkout. 100% Satisfaction Guarantee.
                </p>
            </div>
        </div>

    </div>

    <script>
        // Adding basic interactivity to the exported file
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>
</html>