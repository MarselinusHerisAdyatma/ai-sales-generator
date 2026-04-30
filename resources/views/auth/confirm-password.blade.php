<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="bg-blue-50 w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl text-blue-600">🛡️</div>
        <h2 class="text-xl font-bold text-gray-900">Secure Area</h2>
        <p class="text-sm text-gray-600 mt-2">Confirm password to continue.</p>
    </div>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf
        <x-text-input id="password" class="block w-full border-gray-200 rounded-xl" type="password" name="password" required />
        
        <button class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl mt-6 shadow-lg shadow-blue-200">
            Confirm Access
        </button>
    </form>
</x-guest-layout>