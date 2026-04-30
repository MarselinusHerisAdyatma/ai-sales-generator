<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6">
            <div class="bg-white overflow-hidden shadow-xl rounded-3xl p-10 border border-gray-100">
                
                <div class="flex justify-between items-end mb-10">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900 mb-2">Halo, {{ Auth::user()->name }}! 👋</h1>
                        <p class="text-gray-600">Apa yang ingin Anda jual hari ini?</p>
                    </div>
                    <a href="{{ route('sales-pages.create') }}" class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-semibold hover:bg-blue-700 transition shadow-lg">
                        + Buat Sales Page Baru
                    </a>
                </div>

                <div class="grid md:grid-cols-3 gap-6">
                    <!-- Stat 1 -->
                    <div class="p-6 bg-blue-50 rounded-3xl border border-blue-100">
                        <div class="text-blue-600 font-bold text-lg mb-1">Total Pages</div>
                        <div class="text-4xl font-black text-blue-900">{{ Auth::user()->salesPages()->count() ?? 0 }}</div>
                    </div>

                    <!-- Stat 2 (Hanya Visual) -->
                    <div class="p-6 bg-indigo-50 rounded-3xl border border-indigo-100">
                        <div class="text-indigo-600 font-bold text-lg mb-1">AI Credits</div>
                        <div class="text-4xl font-black text-indigo-900">Unlimited</div>
                    </div>

                    <!-- Stat 3: Quick Link -->
                    <a href="{{ route('sales-pages.index') }}" class="p-6 bg-white rounded-3xl border border-gray-200 hover:border-blue-500 transition group">
                        <div class="text-gray-600 font-bold text-lg mb-1 group-hover:text-blue-600">My Library</div>
                        <div class="text-gray-400 text-sm">Lihat semua halaman yang tersimpan →</div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>