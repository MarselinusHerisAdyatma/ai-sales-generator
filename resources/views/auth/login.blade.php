<x-guest-layout>
    <div class="mb-8 text-center">
        <div class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold mb-4">
            Welcome Back
        </div>
        <h2 class="text-3xl font-extrabold text-gray-900">Login to Account</h2>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        <div>
            <x-input-label for="email" value="Email Address" class="font-semibold text-gray-700" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 rounded-xl focus:ring-blue-500 focus:border-blue-500" type="email" name="email" required autofocus />
        </div>

        <div>
            <div class="flex justify-between">
                <x-input-label for="password" value="Password" class="font-semibold text-gray-700" />
                <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">Forgot?</a>
            </div>
            {{-- Menggunakan komponen password-input yang baru --}}
            <x-password-input id="password" name="password" class="block mt-1 w-full" required />
        </div>
        
        <label class="flex items-center">
            <input type="checkbox" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" name="remember">
            <span class="ms-2 text-sm text-gray-600">Keep me logged in</span>
        </label>

        <button class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl transition shadow-lg shadow-blue-200">
            Log In
        </button>
    </form>
</x-guest-layout>