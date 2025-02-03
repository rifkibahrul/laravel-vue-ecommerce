<x-app-layout>
    <div class="flex flex-col justify-center items-center mt-12 sm:pt-0">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-base dark:text-gray-400">
                {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div>
                    <!-- <x-input-label for="password" :value="__('Password')" /> -->
                    <label for="password" class="text-base font-semibold">Password</label>

                    <x-text-input id="password" 
                        class="form-input" 
                        style="background: url('{{ asset('assets/svgs/ic-lock.svg') }}') no-repeat; background-position: 16px center;"
                        type="password"
                        name="password"
                        required autocomplete="current-password" 
                        placeholder="Your password"/>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="flex justify-end mt-4">
                    <x-primary-button class="hover:bg-orange-600">
                        {{ __('Confirm') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>