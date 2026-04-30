<section class="space-y-6">
    <header>
        <h2 class="text-2xl font-black text-red-600">
            {{ __('Danger Zone') }}
        </h2>
        <p class="mt-2 text-sm text-gray-500 font-medium leading-relaxed">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account Permanently') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-10">
            @csrf
            @method('delete')

            <h2 class="text-2xl font-black text-gray-900">
                {{ __('Are you sure you want to leave?') }}
            </h2>

            <p class="mt-4 text-sm text-gray-600 leading-relaxed">
                {{ __('Once your account is deleted, all of its resources and data (including your generated sales pages) will be permanently deleted. Please enter your password to confirm.') }}
            </p>

            <div class="mt-8">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />
                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="block w-full"
                    placeholder="{{ __('Verify your password to delete') }}"
                />
                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-10 flex flex-col sm:flex-row justify-end gap-4">
                <x-secondary-button x-on:click="$dispatch('close')" class="w-full sm:w-auto justify-center">
                    {{ __('No, Keep My Account') }}
                </x-secondary-button>

                <x-danger-button class="w-full sm:w-auto justify-center">
                    {{ __('Yes, Delete Everything') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>