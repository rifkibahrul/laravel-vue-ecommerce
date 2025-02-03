<x-app-layout>
    <div class="flex flex-col items-center px-6 py-10">
        <img src="{{ asset('assets/images/Logo.svg') }}" alt="logo" class="mb-[53px]">
        <form method="POST" action="{{ route('login') }}" class="mx-auto max-w-[345px] w-full p-6 bg-white rounded-3xl">
            <div class="flex flex-col gap-5">
                <p class="text-[25px] font-bold">
                    Sign In
                </p>
                <!-- <p class="text-center text-gray-500 mb-6">
                    or
                    <a
                        href="{{ route('register') }}"
                        class="text-sm text-purple-600 hover:text-purple-900">
                        {{ __('create new account') }}
                    </a>
                </p> -->

                <!-- Session Status -->
                <x-auth-session-status class="mb-4" :status="session('status')" />
                @csrf

                <!-- Email Address -->
                <div class="flex flex-col gap-2.5">
                    <!-- <x-input-label for="email" :value="__('Email')" /> -->
                    <label for="email" class="text-base font-semibold">Email Address</label>
                    <x-text-input id="email" class="form-input" style="background: url('{{ asset('assets/svgs/ic-email.svg') }}') no-repeat; background-position: 16px center;" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Your email address" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-2.5">
                    <!-- <x-input-label for="password" :value="__('Password')" /> -->
                    <label for="password" class="text-base font-semibold">Password</label>
                    <x-text-input id="password"
                        type="password"
                        name="password"
                        class="form-input"
                        style="background: url('{{ asset('assets/svgs/ic-lock.svg') }}') no-repeat; background-position: 16px center;"
                        required autocomplete="current-password" placeholder="Protect your password" />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <div class="flex items-center justify-end">
                    @if (Route::has('password.request'))
                    <a class="underline text-base text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800" href="{{ route('password.request') }}">
                        {{ __('Forgot your password?') }}
                    </a>
                    @endif

                    <x-primary-button class="ms-3 hover:bg-orange-600">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </div>
        </form>
        <a
            href="{{ route('register') }}"
            class="font-semibold text-lg mt-[30px] underline hover:text-secondary">
            {{ __('Create New Account') }}
        </a>
        <!-- <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        </div> -->
    </div>
</x-app-layout>