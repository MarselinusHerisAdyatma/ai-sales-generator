<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="bg-blue-50 w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl">📧</div>
        <h2 class="text-2xl font-bold text-gray-900">Forgot Password?</h2>
        <p class="text-sm text-gray-600 mt-2">Enter your email for a reset link.</p>
    </div>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <x-text-input id="email" class="block w-full border-gray-200 rounded-xl" type="email" name="email" required />
        
        <button class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl mt-6 shadow-lg shadow-blue-200">
            Send Reset Link
        </button>
    </form>
</x-guest-layout>