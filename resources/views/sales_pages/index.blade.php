<x-app-layout>

<div class="min-h-screen bg-gray-50 py-12">

<div class="max-w-6xl mx-auto px-6">

<div class="flex justify-between items-center mb-8">

<h1 class="text-4xl font-bold">
Saved Sales Pages
</h1>

<a
href="{{ route('sales-pages.create') }}"
class="bg-blue-600 text-white px-5 py-3 rounded-xl">
New Page
</a>

</div>


<div class="grid md:grid-cols-2 gap-6">

@forelse($salesPages as $page)

<div class="bg-white rounded-2xl shadow-lg p-8">

<h2 class="text-2xl font-bold mb-3">
{{ $page->product_name }}
</h2>

<p class="text-gray-600 mb-4">
{{ $page->description }}
</p>

<div class="mb-6 font-semibold">
Rp {{ $page->price }}
</div>


<div class="flex gap-3">

<a
href="{{ route('sales-pages.show',$page->id) }}"
class="bg-indigo-600 text-white px-5 py-3 rounded-xl">
View
</a>


<form
method="POST"
action="{{ route('sales-pages.destroy',$page->id) }}">

@csrf
@method('DELETE')

<button
type="submit"
onclick="return confirm('Delete this sales page?')"
class="bg-red-600 text-white px-5 py-3 rounded-xl">
Delete
</button>

</form>

</div>

</div>


@empty

<div class="col-span-2 bg-white rounded-2xl shadow p-12 text-center">

<h2 class="text-2xl font-semibold mb-3">
No Sales Pages Yet
</h2>

<p class="text-gray-500 mb-6">
Create your first AI-generated sales page.
</p>

<a
href="{{ route('sales-pages.create') }}"
class="bg-blue-600 text-white px-5 py-3 rounded-xl">
Create Now
</a>

</div>

@endforelse

</div>

</div>

</div>

</x-app-layout>