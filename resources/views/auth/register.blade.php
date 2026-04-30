<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold mb-4">
            Join SalesGenie
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900">Create Account</h2>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf
        <div>
            <x-input-label for="name" value="Full Name" />
            <x-text-input id="name" class="block mt-1 w-full border-gray-200 rounded-xl" type="text" name="name" required />
        </div>

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 rounded-xl" type="email" name="email" required />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <x-input-label for="password" value="Password" />
                {{-- Slot Password Utama --}}
                <x-password-input id="password" name="password" class="block mt-1 w-full" required />
            </div>
            <div>
                <x-input-label for="password_confirmation" value="Confirm Password" />
                {{-- Slot Konfirmasi Password --}}
                <x-password-input id="password_confirmation" name="password_confirmation" class="block mt-1 w-full" required />
            </div>
        </div>

        <button class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl mt-4 shadow-lg shadow-blue-200">
            Get Started — Free
        </button>

        <p class="text-center text-sm text-gray-500 mt-6">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-600 font-bold hover:underline">Log in</a>
        </p>
    </form>
</x-guest-layout>