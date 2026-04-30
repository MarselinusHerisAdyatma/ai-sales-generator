<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-3xl text-gray-900 leading-tight">
            {{ __('My Profile Settings') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 space-y-10">
            
            <!-- Card 1: Profile Information -->
            <div class="p-8 sm:p-12 bg-white shadow-xl shadow-gray-200/50 rounded-[2.5rem] border border-gray-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <!-- Card 2: Update Password -->
            <div class="p-8 sm:p-12 bg-white shadow-xl shadow-gray-200/50 rounded-[2.5rem] border border-gray-100">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <!-- Card 3: Delete Account -->
            <div class="p-8 sm:p-12 bg-white shadow-xl shadow-gray-200/50 rounded-[2.5rem] border border-red-50">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>