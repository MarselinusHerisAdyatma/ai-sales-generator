<x-app-layout>

<div class="min-h-screen bg-gray-50 py-14">

<div class="max-w-6xl mx-auto px-6">

<div class="bg-gradient-to-r from-blue-600 to-indigo-700 text-white rounded-3xl p-14 text-center shadow-xl">

<h1 class="text-5xl font-bold mb-4">
{{ $content['headline'] }}
</h1>

<p class="text-xl opacity-90 mb-10">
{{ $content['subheadline'] }}
</p>

<a
href="#pricing"
class="inline-block bg-white text-blue-700 px-8 py-4 rounded-xl font-semibold">
{{ $content['cta'] }}
</a>

</div>


<div class="grid md:grid-cols-3 gap-6 mt-10">

@foreach($content['benefits'] as $benefit)

<div class="bg-white rounded-2xl shadow p-8 text-center">
<h3 class="text-xl font-semibold">
{{ $benefit }}
</h3>
</div>

@endforeach

</div>


<div class="bg-white rounded-3xl shadow-xl p-10 mt-10 text-center">

<p class="text-gray-500 mb-4">
{{ $content['social_proof'] ?? 'Trusted by 1,000+ happy customers' }}
</p>

<div id="pricing" class="text-5xl font-bold mb-6">
Rp {{ $salesPage->price }}
</div>

<button
class="bg-blue-600 hover:bg-blue-700 text-white px-10 py-4 rounded-xl font-semibold">
{{ $content['cta'] }}
</button>

</div>

</div>

</div>

</x-app-layout>