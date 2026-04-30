<x-guest-layout>
    <div class="mb-6 text-center">
        <div class="bg-blue-50 w-14 h-14 rounded-2xl flex items-center justify-center mx-auto mb-4 text-xl">✨</div>
        <h2 class="text-2xl font-bold text-gray-900">Verify Your Email</h2>
        <p class="text-sm text-gray-600 mt-2">Check your inbox for a verification link.</p>
    </div>

    <div class="mt-8 space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl shadow-lg">
                Resend Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full text-sm text-gray-500 hover:text-blue-600 underline font-medium">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>