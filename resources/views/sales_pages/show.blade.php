<x-app-layout>
    <style>
        .glass-btn {
            backdrop-filter: blur(4px);
            border: 1px solid rgba(0,0,0,0.05);
            transition: all 0.2s ease-in-out;
        }
        .group:hover .regen-trigger { opacity: 1; transform: translateY(0); }
        @media print { .no-print { display: none !important; } }
    </style>

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
                'advantage_title' => 'text-indigo-900', // TAMBAHKAN INI
                'advantage_text' => 'text-indigo-700',  // TAMBAHKAN INI
                'regen_btn' => 'bg-white/20 text-white hover:bg-white/40',
                'regen_btn_alt' => 'bg-blue-50 text-blue-600 hover:bg-blue-100',
                'btn_cta' => 'bg-blue-600 hover:bg-blue-700 text-white shadow-blue-200',
                'price_card' => 'bg-white border-gray-50', // Tambahkan untuk konsistensi
                'price_text' => 'text-gray-900'            // Tambahkan untuk konsistensi
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
                'regen_btn' => 'bg-white/10 text-amber-400 hover:bg-white/20',
                'regen_btn_alt' => 'bg-gray-800 text-amber-400 hover:bg-gray-700',
                'btn_cta' => 'bg-amber-500 hover:bg-amber-600 text-black shadow-amber-900/20',
                'price_card' => 'bg-gray-900 border-gray-800',
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
                'regen_btn' => 'bg-gray-100 text-gray-600 hover:bg-gray-200',
                'regen_btn_alt' => 'bg-gray-100 text-gray-900 hover:bg-gray-200',
                'btn_cta' => 'bg-black hover:bg-gray-800 text-white shadow-xl',
                'price_card' => 'bg-white border-gray-200',
                'price_text' => 'text-gray-900'
            ]
        ];

        $theme = $themes[$salesPage->template] ?? $themes['professional'];
        $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
        $formattedPrice = $formatter->formatCurrency((float)$salesPage->price, $salesPage->currency);
    @endphp

    <div class="min-h-screen {{ $theme['bg_main'] }} py-14 transition-colors duration-500">
        <div class="max-w-6xl mx-auto px-6">
            
            <!-- Navbar -->
            <div class="flex justify-between items-center mb-12 bg-white p-4 rounded-2xl shadow-sm border border-gray-100 no-print">
                <a href="{{ route('sales-pages.index') }}" class="text-gray-500 font-bold hover:text-blue-600 transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7" stroke-width="3"/></svg> Back
                </a>
                <div class="flex gap-3 no-print">
                    <a href="{{ route('sales-pages.export-html', $salesPage->id) }}" class="text-green-600 font-bold bg-green-50 px-5 py-2.5 rounded-xl hover:bg-green-600 hover:text-white transition">Download HTML</a>
                    <button onclick="window.print()" class="text-blue-600 font-bold bg-blue-50 px-5 py-2.5 rounded-xl hover:bg-blue-600 hover:text-white transition">Print PDF</button>
                </div>
            </div>

            <!-- Hero Section -->
            <div class="group relative bg-gradient-to-br {{ $theme['hero'] }} rounded-[3rem] p-20 text-center shadow-2xl relative overflow-hidden transition-all duration-500">
                <!-- Toolbar Regen -->
                <div class="regen-trigger opacity-0 translate-y-2 absolute top-6 right-6 transition-all duration-300 no-print z-30">
                    <form action="{{ route('sales-pages.regenerate-section', $salesPage->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="section" value="headline">
                        <button type="submit" class="glass-btn {{ $theme['regen_btn'] }} px-4 py-2 rounded-xl text-xs font-black uppercase tracking-widest flex items-center gap-2">
                            🔄 Rewrite Headline
                        </button>
                    </form>
                </div>

                <h1 class="text-6xl font-black mb-6 leading-tight relative z-10">{{ $content['headline'] ?? 'Headline Pending...' }}</h1>
                <p class="text-2xl opacity-80 mb-12 max-w-3xl mx-auto leading-relaxed relative z-10">{{ $content['subheadline'] ?? '' }}</p>
                <div class="relative z-10">
                    <a href="#pricing" class="inline-block {{ $theme['btn_hero'] }} px-10 py-5 rounded-2xl font-black text-xl shadow-xl hover:scale-105 transition-transform uppercase tracking-wider">
                        {{ $content['cta'] ?? 'Buy Now' }}
                    </a>
                </div>
            </div>

            <!-- Benefits -->
            <div class="mt-24 group relative">
                <div class="flex flex-col items-center mb-16">
                    <h2 class="text-3xl font-black {{ $theme['text_title'] }} uppercase tracking-widest mb-4">Why Choose Us?</h2>
                    <!-- Toolbar Regen Benefits -->
                    <form action="{{ route('sales-pages.regenerate-section', $salesPage->id) }}" method="POST" class="regen-trigger opacity-0 translate-y-2 transition-all duration-300 no-print">
                        @csrf
                        <input type="hidden" name="section" value="benefits">
                        <button type="submit" class="glass-btn {{ $theme['regen_btn_alt'] }} px-4 py-2 rounded-xl text-[10px] font-black uppercase tracking-widest flex items-center gap-2">
                            ✨ Remix All Benefits
                        </button>
                    </form>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    @forelse(array_slice($content['benefits'] ?? [], 0, 3) as $benefit)
                        <div class="{{ $theme['benefit_card'] }} rounded-[2rem] shadow-xl p-10 text-center border group/card hover:scale-[1.02] transition-all">
                            <div class="w-16 h-16 {{ $theme['accent'] }} bg-opacity-10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                                <svg class="w-8 h-8 {{ $theme['accent'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <h3 class="text-xl font-black {{ $theme['text_title'] }}">{{ $benefit }}</h3>
                        </div>
                    @empty
                        <p class="col-span-full text-center text-gray-400 italic mb-10">No benefits generated yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Advantage -->
            <div class="mt-20 {{ $theme['advantage_box'] }} rounded-[3rem] p-12 border flex flex-col md:flex-row items-center gap-10 transition-all">
                <div class="flex-1 text-center md:text-left">
                    {{-- Gunakan advantage_title --}}
                    <h2 class="text-3xl font-black {{ $theme['advantage_title'] }} mb-4 italic">
                        The {{ $salesPage->product_name }} Advantage
                    </h2>

                    {{-- HAPUS opacity-70, GANTI dengan advantage_text --}}
                    <p class="text-xl {{ $theme['advantage_text'] }} leading-relaxed font-medium italic">
                        "{{ $salesPage->unique_selling_points }}"
                    </p>
                </div>
                <div class="bg-white p-8 rounded-full shadow-2xl animate-bounce hidden md:block">
                    <span class="text-5xl">⚡</span>
                </div>
            </div>

            <!-- Pricing (FIXED) -->
            <div id="pricing" class="group relative {{ $theme['card'] }} rounded-[3rem] shadow-2xl p-16 mt-20 text-center border overflow-visible transition-all">
                <!-- Toolbar Regen CTA -->
                <div class="regen-trigger opacity-0 translate-y-2 absolute -top-5 right-10 transition-all duration-300 no-print z-30">
                    <form action="{{ route('sales-pages.regenerate-section', $salesPage->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="section" value="cta">
                        <button type="submit" class="glass-btn {{ $theme['regen_btn_alt'] }} px-5 py-2.5 rounded-xl text-xs font-black uppercase tracking-widest shadow-lg flex items-center gap-2">
                            🎯 Optimize Offer
                        </button>
                    </form>
                </div>

                <div class="max-w-2xl mx-auto">
                    <!-- SOCIAL PROOF -->
                    <p class="{{ $theme['accent'] }} font-black uppercase tracking-[0.2em] text-sm mb-6">
                        {{ !empty($content['social_proof']) ? $content['social_proof'] : 'Limited Time Offer' }}
                    </p>
                    
                    <h2 class="text-4xl font-black {{ $theme['text_title'] }} mb-10 italic leading-snug">
                        "The best investment for your business growth."
                    </h2>
                    
                    <div class="text-7xl font-black {{ $theme['text_title'] }} mb-12 tracking-tighter">
                        {{ $formattedPrice }}
                    </div>
                    
                    <!-- TOMBOL GET STARTED NOW -->
                    <button class="{{ $theme['btn_cta'] }} px-16 py-6 rounded-2xl font-black text-2xl shadow-2xl active:scale-95 transition-all w-full md:w-auto uppercase tracking-widest">
                        {{ !empty($content['cta']) ? $content['cta'] : 'Get Started Now' }}
                    </button>
                    
                    <p class="mt-8 text-gray-400 text-[10px] font-medium uppercase tracking-tight">
                        Secure checkout. 100% Satisfaction Guarantee.
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>