<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')


        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
                <x-input-error class="mt-2" :messages="$errors->get('email')" />

                @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                    <div>
                        <p class="text-sm mt-2 text-gray-800">
                            {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="btn">
                                {{ __('Click here to re-send the verification email.') }}
                            </button>
                        </p>
                        @if (session('status') === 'verification-link-sent')
                            <p class="mt-2 font-medium text-sm text-green-600">
                                {{ __('A new verification link has been sent to your email address.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        </div>

        @php $authUser = Auth::user(); @endphp
        @if($authUser && $authUser->role === 'Supplier')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
                <x-input-label for="company_name" :value="__('Company Name')" />
                <x-text-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" :value="old('company_name', $authUser->company_name)" autocomplete="organization" />
                <x-input-error class="mt-2" :messages="$errors->get('company_name')" />
            </div>
            <div>
                <x-input-label for="company_address" :value="__('Company Address')" />
                <x-text-input id="company_address" name="company_address" type="text" class="mt-1 block w-full" :value="old('company_address', $authUser->company_address)" autocomplete="street-address" />
                <x-input-error class="mt-2" :messages="$errors->get('company_address')" />
            </div>
        </div>
        <div class="mt-8 mb-2 font-semibold text-gray-700 text-lg">1st Contact / Position</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="contact1_name" :value="__('Name')" />
                <x-text-input id="contact1_name" name="contact1_name" type="text" class="mt-1 block w-full" :value="old('contact1_name', $authUser->contact1_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact1_name')" />
            </div>
            <div>
                <x-input-label for="contact1_position" :value="__('Position')" />
                <x-text-input id="contact1_position" name="contact1_position" type="text" class="mt-1 block w-full" :value="old('contact1_position', $authUser->contact1_position)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact1_position')" />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
            <div>
                <x-input-label for="contact1_mail" :value="__('Mail')" />
                <x-text-input id="contact1_mail" name="contact1_mail" type="email" class="mt-1 block w-full" :value="old('contact1_mail', $authUser->contact1_mail)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact1_mail')" />
            </div>
            <div>
                <x-input-label for="contact1_mobile" :value="__('Mobile')" />
                <x-text-input id="contact1_mobile" name="contact1_mobile" type="text" class="mt-1 block w-full" :value="old('contact1_mobile', $authUser->contact1_mobile)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact1_mobile')" />
            </div>
            <div>
                <x-input-label for="contact1_phone" :value="__('Phone')" />
                <x-text-input id="contact1_phone" name="contact1_phone" type="text" class="mt-1 block w-full" :value="old('contact1_phone', $authUser->contact1_phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact1_phone')" />
            </div>
        </div>
        <div class="mt-8 mb-2 font-semibold text-gray-700 text-lg">2nd Contact / Position</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <x-input-label for="contact2_name" :value="__('Name')" />
                <x-text-input id="contact2_name" name="contact2_name" type="text" class="mt-1 block w-full" :value="old('contact2_name', $authUser->contact2_name)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact2_name')" />
            </div>
            <div>
                <x-input-label for="contact2_position" :value="__('Position')" />
                <x-text-input id="contact2_position" name="contact2_position" type="text" class="mt-1 block w-full" :value="old('contact2_position', $authUser->contact2_position)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact2_position')" />
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-2">
            <div>
                <x-input-label for="contact2_mail" :value="__('Mail')" />
                <x-text-input id="contact2_mail" name="contact2_mail" type="email" class="mt-1 block w-full" :value="old('contact2_mail', $authUser->contact2_mail)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact2_mail')" />
            </div>
            <div>
                <x-input-label for="contact2_mobile" :value="__('Mobile')" />
                <x-text-input id="contact2_mobile" name="contact2_mobile" type="text" class="mt-1 block w-full" :value="old('contact2_mobile', $authUser->contact2_mobile)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact2_mobile')" />
            </div>
            <div>
                <x-input-label for="contact2_phone" :value="__('Phone')" />
                <x-text-input id="contact2_phone" name="contact2_phone" type="text" class="mt-1 block w-full" :value="old('contact2_phone', $authUser->contact2_phone)" />
                <x-input-error class="mt-2" :messages="$errors->get('contact2_phone')" />
            </div>
        </div>
        @endif

        <div class="flex items-center gap-4">
            <button class="btn" type="submit">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
