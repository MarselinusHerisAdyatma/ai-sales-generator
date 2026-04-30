<x-guest-layout>
    <div class="mb-8 text-center">
        <h2 class="text-2xl font-bold text-gray-900">Set New Password</h2>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}">
        
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 rounded-xl" type="email" name="email" :value="old('email', $request->email)" required />
        </div>

        <div>
            <x-input-label for="password" value="New Password" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-200 rounded-xl" type="password" name="password" required />
        </div>

        <div>
            <x-input-label for="password_confirmation" value="Confirm New Password" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-200 rounded-xl" type="password" name="password_confirmation" required />
        </div>

        <button class="w-full py-4 bg-blue-600 text-white font-bold rounded-xl mt-4 shadow-lg">
            Update Password
        </button>
    </form>
</x-guest-layout>