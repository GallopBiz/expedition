<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit User') }}
        </h2>
    </x-slot>
    <div class="max-w-3xl mx-auto px-2 sm:px-4 lg:px-8 py-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <form method="POST" action="{{ route('users.update', $user->id) }}">
                    @csrf
                    @method('PUT')
                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>
                    <!-- Email and Phone (Two column) -->
                    <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="phone" :value="__('Phone Number (1st Contact)')" />
                            <x-text-input id="phone" class="block mt-1 w-full" type="text" name="phone" value="{{ old('phone', $user->phone) }}" autocomplete="tel" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                    </div>
                    <!-- Role (One column) -->
                    <div class="mt-4">
                        <x-input-label for="role" :value="__('Role')" />
                        <select id="role" name="role" class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 focus:outline-none text-sm font-sans" required>
                            <option value="">Select Role</option>
                            <option value="Manager" @if(old('role', $user->role)=='Manager') selected @endif>Manager</option>
                            <option value="Expeditor" @if(old('role', $user->role)=='Expeditor') selected @endif>Expeditor</option>
                            <option value="Supplier" @if(old('role', $user->role)=='Supplier') selected @endif>Supplier</option>
                        </select>
                        <x-input-error :messages="$errors->get('role')" class="mt-2" />
                    </div>
                    <!-- Company Details (Supplier only) -->
                    @if(old('role', $user->role) == 'Supplier')
                    <div class="mt-4">
                        <x-input-label for="company_name" :value="__('Company Name')" />
                        <x-text-input id="company_name" class="block mt-1 w-full" type="text" name="company_name" value="{{ old('company_name', $user->company_name) }}" autocomplete="organization" />
                        <x-input-error :messages="$errors->get('company_name')" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <x-input-label for="company_address" :value="__('Company Address')" />
                        <x-text-input id="company_address" class="block mt-1 w-full" type="text" name="company_address" value="{{ old('company_address', $user->company_address) }}" autocomplete="street-address" />
                        <x-input-error :messages="$errors->get('company_address')" class="mt-2" />
                    </div>
                    <div class="mt-6 mb-2 font-semibold text-gray-700">1st Contact / Position</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="contact1_name" :value="__('Name')" />
                            <x-text-input id="contact1_name" class="block mt-1 w-full" type="text" name="contact1_name" value="{{ old('contact1_name', $user->contact1_name) }}" />
                            <x-input-error :messages="$errors->get('contact1_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact1_position" :value="__('Position')" />
                            <x-text-input id="contact1_position" class="block mt-1 w-full" type="text" name="contact1_position" value="{{ old('contact1_position', $user->contact1_position) }}" />
                            <x-input-error :messages="$errors->get('contact1_position')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">
                        <div>
                            <x-input-label for="contact1_mail" :value="__('Mail')" />
                            <x-text-input id="contact1_mail" class="block mt-1 w-full" type="email" name="contact1_mail" value="{{ old('contact1_mail', $user->contact1_mail) }}" />
                            <x-input-error :messages="$errors->get('contact1_mail')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact1_mobile" :value="__('Mobile')" />
                            <x-text-input id="contact1_mobile" class="block mt-1 w-full" type="text" name="contact1_mobile" value="{{ old('contact1_mobile', $user->contact1_mobile) }}" />
                            <x-input-error :messages="$errors->get('contact1_mobile')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact1_phone" :value="__('Phone')" />
                            <x-text-input id="contact1_phone" class="block mt-1 w-full" type="text" name="contact1_phone" value="{{ old('contact1_phone', $user->contact1_phone) }}" />
                            <x-input-error :messages="$errors->get('contact1_phone')" class="mt-2" />
                        </div>
                    </div>
                    <div class="mt-6 mb-2 font-semibold text-gray-700">2nd Contact / Position</div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="contact2_name" :value="__('Name')" />
                            <x-text-input id="contact2_name" class="block mt-1 w-full" type="text" name="contact2_name" value="{{ old('contact2_name', $user->contact2_name) }}" />
                            <x-input-error :messages="$errors->get('contact2_name')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact2_position" :value="__('Position')" />
                            <x-text-input id="contact2_position" class="block mt-1 w-full" type="text" name="contact2_position" value="{{ old('contact2_position', $user->contact2_position) }}" />
                            <x-input-error :messages="$errors->get('contact2_position')" class="mt-2" />
                        </div>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mt-2">
                        <div>
                            <x-input-label for="contact2_mail" :value="__('Mail')" />
                            <x-text-input id="contact2_mail" class="block mt-1 w-full" type="email" name="contact2_mail" value="{{ old('contact2_mail', $user->contact2_mail) }}" />
                            <x-input-error :messages="$errors->get('contact2_mail')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact2_mobile" :value="__('Mobile')" />
                            <x-text-input id="contact2_mobile" class="block mt-1 w-full" type="text" name="contact2_mobile" value="{{ old('contact2_mobile', $user->contact2_mobile) }}" />
                            <x-input-error :messages="$errors->get('contact2_mobile')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact2_phone" :value="__('Phone')" />
                            <x-text-input id="contact2_phone" class="block mt-1 w-full" type="text" name="contact2_phone" value="{{ old('contact2_phone', $user->contact2_phone) }}" />
                            <x-input-error :messages="$errors->get('contact2_phone')" class="mt-2" />
                        </div>
                    </div>
                    @endif
                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('users.index') }}" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Cancel</a>
                        <x-primary-button class="ms-4">
                            {{ __('Update User') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>

            <div class="mt-8"></div>
            <!-- Success alert for profile update -->
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">
                    <span class="font-semibold">{{ session('success') }}</span>
                </div>
            @endif
            <div class="p-8 bg-white shadow-lg rounded-2xl border border-gray-100">
                <div class="w-full">
                    <h3 class="text-lg font-bold text-gray-700 mb-4">Change Password</h3>
                    @if(session('status') === 'password-updated')
                        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2500)" class="mb-6 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-lg shadow">
                            <span class="font-semibold">Password updated successfully!</span>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('users.update', $user->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="password" :value="__('New Password (optional)')" />
                                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" autocomplete="new-password" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ms-4">
                                {{ __('Update Password') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
</x-app-layout>
