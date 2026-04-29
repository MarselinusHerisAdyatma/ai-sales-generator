<x-app-layout>

<div class="min-h-screen bg-gray-50 py-12">

<div class="max-w-5xl mx-auto px-6">

<div class="grid md:grid-cols-2 gap-10 items-center">

<div>
<span class="inline-block px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm mb-4">
AI Sales Generator
</span>

<h1 class="text-5xl font-bold leading-tight text-gray-900 mb-4">
Generate Persuasive
Sales Pages in Minutes
</h1>

<p class="text-lg text-gray-600">
Turn raw product information into structured landing page copy.
</p>
</div>


<div class="bg-white rounded-3xl shadow-xl p-8">

<form method="POST" action="{{ route('sales-pages.store') }}">
@csrf

<div class="space-y-5">

<div>
<label class="block font-medium mb-2">
Product Name
</label>

<input
type="text"
name="product_name"
placeholder="AI Sales Copy Toolkit"
class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500">
</div>


<div>
<label class="block font-medium mb-2">
Description
</label>

<textarea
name="description"
rows="4"
placeholder="Describe your product..."
class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-blue-500"></textarea>
</div>


<div>
<label class="block font-medium mb-2">
Features
</label>

<input
type="text"
name="features"
placeholder="Templates, Export, AI Copy"
class="w-full border border-gray-300 rounded-xl p-3">
</div>


<div class="grid md:grid-cols-2 gap-4">

<div>
<label class="block font-medium mb-2">
Audience
</label>

<input
type="text"
name="target_audience"
class="w-full border border-gray-300 rounded-xl p-3">
</div>


<div>
<label class="block font-medium mb-2">
Price
</label>

<input
type="text"
name="price"
class="w-full border border-gray-300 rounded-xl p-3">
</div>

</div>


<div>
<label class="block font-medium mb-2">
Unique Selling Points
</label>

<input
type="text"
name="unique_selling_points"
class="w-full border border-gray-300 rounded-xl p-3">
</div>


<button
type="submit"
class="w-full bg-blue-600 hover:bg-blue-700 text-white py-4 rounded-xl font-semibold">
Generate Sales Page
</button>

</div>

</form>

</div>

</div>

</div>

</div>

</x-app-layout>