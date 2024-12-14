<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('patch')

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
                <p class="text-sm mt-2 text-gray-800 dark:text-gray-200">
                    {{ __('Your email address is unverified.') }}

                    <button form="send-verification" class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Click here to re-send the verification email.') }}
                    </button>
                </p>

                @if (session('status') === 'verification-link-sent')
                <p class="mt-2 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to your email address.') }}
                </p>
                @endif
            </div>
            @endif
        </div>

        <div class="flex space-x-4">
            <div class="w-1/2">
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $customer->first_name)" required autofocus autocomplete="first_name" />
                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
            </div>

            <div class="w-1/2">
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $customer->last_name)" required autofocus autocomplete="last_name" />
                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
            </div>
        </div>

        <div>
            <x-input-label for="address" :value="__('Address')" />
            <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="old('address', $customerAddress->address)" required autofocus autocomplete="address" />
            <x-input-error class="mt-2" :messages="$errors->get('address')" />
        </div>

        <div class="flex space-x-4">
            <div class="w-1/2">
                <x-input-label for="phone" :value="__('Phone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $customer->phone)" required autofocus autocomplete="phone" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div class="w-1/2">
                <x-input-label for="zipcode" :value="__('Zipcode')" />
                <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full" :value="old('zipcode', $customerAddress->zipcode)" required autofocus autocomplete="zipcode" />
                <x-input-error class="mt-2" :messages="$errors->get('zipcode')" />
            </div>
        </div>

        <div x-data="provinceCity()" class="flex space-x-4">
            <div class="w-1/2">
                <x-input-label for="province" :value="__('Province')" />
                <select @change="getCity($event)" name="province_id" id="province" class="mt-1 block w-full" required>
                    <option value="">{{ __('Select Province') }}</option>
                    @foreach ($listProvince as $province)
                    <option value="{{ $province['province_id'] }}"
                        {{ old('province_id', $customerAddress->province_id) == $province['province_id']? 'selected' : '' }}>
                        {{ $province['province'] }}
                    </option>
                    @endforeach
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('province_id')" />
            </div>

            <div class="w-1/2">
                <x-input-label for="city" :value="__('City')" />
                <select name="city_id" id="city" class="mt-1 block w-full" required>
                    <option value="">{{ __('Select City') }}</option>
                    <template x-for="city in listCity" :key="city.city_id">
                        <option :value="city.city_id" x-text="city.city_name"></option>
                    </template>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('city_id')" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
            <p
                x-data="{ show: true }"
                x-show="show"
                x-transition
                x-init="setTimeout(() => show = false, 2000)"
                class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>