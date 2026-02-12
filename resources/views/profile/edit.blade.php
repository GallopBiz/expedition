<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto px-2 sm:px-4 lg:px-8 space-y-8">
            @if(session('status') === 'profile-updated')
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">
                    <span class="font-semibold">Profile updated successfully!</span>
                </div>
            @endif
            <div class="p-8 bg-white shadow-lg rounded-2xl border border-gray-100">
                <div class="w-full">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="mt-8"></div>
            <div class="p-8 bg-white shadow-lg rounded-2xl border border-gray-100">
                <div class="w-full">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Change Password</h3>
                    @if(session('status') === 'password-updated')
                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">
                            <span class="font-semibold">Password updated successfully!</span>
                        </div>
                    @endif
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            @php $authUser = Auth::user(); @endphp
            @if(!$authUser || $authUser->role !== 'Supplier')
            <div class="p-8 bg-white shadow-lg rounded-2xl border border-gray-100">
                <div class="w-full">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
