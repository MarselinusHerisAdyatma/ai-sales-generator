<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-black text-gray-900">
                {{ __('Saved Sales Pages') }}
            </h1>
            <a href="{{ route('sales-pages.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition shadow-lg shadow-blue-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="3"/></svg>
                New Page
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($salesPages as $page)
                <div class="bg-white rounded-[2rem] shadow-xl shadow-gray-200/50 p-8 border border-gray-100 hover:scale-[1.02] transition-all group">
                    <div class="flex justify-between items-start mb-6">
                        <div class="bg-blue-50 text-blue-600 p-3 rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" stroke-width="2"/></svg>
                        </div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">{{ $page->created_at->format('d M Y') }}</span>
                    </div>

                    <h2 class="text-2xl font-black text-gray-900 mb-3 group-hover:text-blue-600 transition">
                        {{ $page->product_name }}
                    </h2>

                    <p class="text-gray-500 mb-6 line-clamp-3 text-sm leading-relaxed">
                        {{ $page->description }}
                    </p>

                    <!-- PERBAIKAN: Format Mata Uang Otomatis -->
                    <div class="flex items-center justify-between mb-8">
                        <span class="text-gray-400 text-xs font-bold uppercase">Price</span>
                        <div class="text-xl font-black text-gray-900">
                            @php
                                $formatter = new \NumberFormatter('en_US', \NumberFormatter::CURRENCY);
                                echo $formatter->formatCurrency((float)$page->price, $page->currency);
                            @endphp
                        </div>
                    </div>

                    <!-- MODIFIKASI: Tombol Navigasi (View, Edit, Delete) -->
                    <div class="flex flex-col gap-3">
                        <div class="flex gap-3">
                            <a href="{{ route('sales-pages.show', $page->id) }}" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-xl font-bold text-sm shadow-md shadow-blue-100 transition">
                                View Page
                            </a>

                            <!-- TOMBOL BARU: Edit / Re-generate -->
                            <a href="{{ route('sales-pages.edit', $page->id) }}" class="bg-amber-50 text-amber-600 p-3 rounded-xl hover:bg-amber-600 hover:text-white transition shadow-sm" title="Edit & Re-generate">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </a>

                            <form method="POST" action="{{ route('sales-pages.destroy', $page->id) }}" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Hapus halaman ini?')" class="bg-red-50 text-red-600 p-3 rounded-xl hover:bg-red-600 hover:text-white transition shadow-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                    <div class="col-span-full bg-white rounded-[3rem] p-20 text-center border-2 border-dashed border-gray-200">
                        <div class="text-6xl mb-6">📂</div>
                        <h2 class="text-3xl font-black text-gray-900 mb-2">No Sales Pages Yet</h2>
                        <p class="text-gray-500 mb-10 max-w-sm mx-auto">Mulai buat halaman sales pertama Anda dengan teknologi AI tercanggih.</p>
                        <a href="{{ route('sales-pages.create') }}" class="bg-blue-600 text-white px-10 py-4 rounded-2xl font-bold shadow-xl shadow-blue-200 hover:bg-blue-700 transition">
                            Create First Page
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>