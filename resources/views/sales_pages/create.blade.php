<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-16 items-start">
                
                <!-- Left Side: International Branding -->
                <div class="lg:col-span-5">
                    <div class="inline-block px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-xs font-black uppercase tracking-widest mb-6">
                        ✨ Global AI Engine
                    </div>
                    <h1 class="text-5xl font-black leading-tight text-gray-900 mb-6">
                        {{ isset($salesPage) ? 'Edit & Re-generate' : 'Build World-Class' }} <span class="text-blue-600">Sales Pages</span>
                    </h1>
                    <p class="text-xl text-gray-600 leading-relaxed mb-8">
                        Turn your product details into high-converting copy designed to captivate a global audience.
                    </p>
                    
                    <ul class="space-y-4">
                        <li class="flex items-center gap-3 font-bold text-gray-700">
                            <div class="bg-blue-600 text-white p-1 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3"/></svg>
                            </div>
                            Conversion-Optimized Headlines
                        </li>
                        <li class="flex items-center gap-3 font-bold text-gray-700">
                            <div class="bg-blue-600 text-white p-1 rounded-full">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M5 13l4 4L19 7" stroke-width="3"/></svg>
                            </div>
                            Professional Landing Page Structure
                        </li>
                    </ul>
                </div>

                <!-- Right Side: The Form -->
                <div class="lg:col-span-7 w-full">
                    <div class="bg-white rounded-[3rem] shadow-2xl shadow-gray-200/50 p-10 border border-gray-50">
                        
                        <!-- MODIFIKASI: Action dan Method dinamis -->
                        <form method="POST" action="{{ isset($salesPage) ? route('sales-pages.update', $salesPage->id) : route('sales-pages.store') }}">
                            @csrf
                            @if(isset($salesPage))
                                @method('PUT')
                            @endif

                            <div class="space-y-6">
                                <!-- Product Name -->
                                <div>
                                    <x-input-label for="product_name" value="Product Name" />
                                    <x-text-input type="text" name="product_name" id="product_name" 
                                        value="{{ old('product_name', $salesPage->product_name ?? '') }}" 
                                        placeholder="e.g. Premium Running Shoes" class="w-full mt-2" required />
                                </div>

                                <!-- Product Description -->
                                <div>
                                    <x-input-label for="description" value="Product Description" />
                                    <textarea name="description" rows="4" placeholder="What makes this product amazing?" 
                                        class="w-full mt-2 border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all">{{ old('description', $salesPage->description ?? '') }}</textarea>
                                </div>

                                <div class="grid md:grid-cols-2 gap-6">
                                    <!-- Target Audience -->
                                    <div>
                                        <x-input-label for="target_audience" value="Target Audience" />
                                        <x-text-input type="text" name="target_audience" id="target_audience" 
                                            value="{{ old('target_audience', $salesPage->target_audience ?? '') }}" 
                                            placeholder="e.g. Freelancers, Athletes" class="w-full mt-2" />
                                    </div>
                                    
                                    <!-- Price & Currency -->
                                    <div>
                                        <x-input-label for="price" value="Price & Currency" />
                                        <!-- MODIFIKASI: Selected awal diambil dari data lama -->
                                        <div class="flex mt-2" x-data="{ 
                                            open: false, 
                                            selected: '{{ old('currency', $salesPage->currency ?? 'USD') }}',
                                            currencies: @js($currencies)
                                        }">
                                            <input type="hidden" name="currency" :value="selected">

                                            <div class="relative">
                                                <button type="button" @click="open = !open" @click.away="open = false"
                                                    class="h-full px-4 rounded-l-2xl border border-gray-200 border-r-0 bg-gray-50 font-black text-gray-700 focus:outline-none flex items-center gap-2 min-w-[90px] justify-between">
                                                    <span x-text="selected"></span>
                                                    <svg class="w-4 h-4 transition-transform" :class="open ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7" stroke-width="2"/></svg>
                                                </button>

                                                <div x-show="open" x-cloak
                                                    x-transition:enter="transition ease-out duration-100"
                                                    x-transition:enter-start="opacity-0 scale-95"
                                                    x-transition:enter-end="opacity-100 scale-100"
                                                    class="absolute z-50 mt-2 w-72 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 max-h-64 overflow-y-auto">
                                                    
                                                    <template x-for="(name, code) in currencies" :key="code">
                                                        <button type="button" @click="selected = code; open = false"
                                                            class="w-full text-left px-4 py-3 hover:bg-blue-50 transition-colors flex flex-col">
                                                            <span class="font-black text-gray-900" x-text="code"></span>
                                                            <span class="text-xs text-gray-500" x-text="name"></span>
                                                        </button>
                                                    </template>
                                                </div>
                                            </div>

                                            <x-text-input type="number" name="price" id="price" step="0.01"
                                                value="{{ old('price', $salesPage->price ?? '') }}" 
                                                placeholder="99.99" 
                                                class="w-full rounded-l-none rounded-r-2xl border-l-0 focus:ring-blue-500 focus:border-blue-500" required />
                                        </div>
                                    </div>

                                    <!-- TAMBAHKAN BLOK INI DI SINI -->
                                    <div class="mt-6">
                                        <x-input-label for="template" value="Select Design Template" />
                                        <select name="template" id="template" class="w-full mt-2 border-gray-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all font-bold text-gray-700">
                                            <option value="professional" {{ old('template', $salesPage->template ?? '') == 'professional' ? 'selected' : '' }}>Professional Blue (Default)</option>
                                            <option value="midnight" {{ old('template', $salesPage->template ?? '') == 'midnight' ? 'selected' : '' }}>Midnight Elegant (Dark Mode)</option>
                                            <option value="minimalist" {{ old('template', $salesPage->template ?? '') == 'minimalist' ? 'selected' : '' }}>Clean Minimalist (White & Serif)</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Key Features -->
                                <div>
                                    <x-input-label for="features" value="Key Features (Comma separated)" />
                                    <x-text-input type="text" name="features" id="features" 
                                        value="{{ old('features', $salesPage->features ?? '') }}" 
                                        placeholder="Lightweight, Waterproof, Durable" class="w-full mt-2" />
                                </div>

                                <!-- Unique Selling Points -->
                                <div>
                                    <x-input-label for="unique_selling_points" value="Unique Selling Points" />
                                    <textarea id="unique_selling_points" name="unique_selling_points" rows="3" 
                                        class="block mt-1 w-full border-gray-200 rounded-2xl focus:ring-blue-500 focus:border-blue-500" 
                                        placeholder="What makes you different from competitors?">{{ old('unique_selling_points', $salesPage->unique_selling_points ?? '') }}</textarea>
                                    <p class="mt-2 text-xs text-gray-400 italic">Example: Only provider with 24/7 human support in Asia.</p>
                                </div>

                                <!-- MODIFIKASI: Tombol dinamis -->
                                <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-black text-lg shadow-xl shadow-blue-200 transition-all active:scale-95 flex items-center justify-center gap-3">
                                    {{ isset($salesPage) ? '🔄 Re-generate Sales Page' : '🚀 Generate Sales Page' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>