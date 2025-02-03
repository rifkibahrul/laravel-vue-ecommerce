<x-app-layout>
    <div class="flex flex-col justify-center items-center mt-12 sm:pt-0 dark:bg-gray-900">
        <div class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            <div class="mb-4 text-base dark:text-gray-400">
                {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
            </div>
        
            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />
        
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
        
                <!-- Email Address -->
                <div>
                    <!-- <x-input-label for="email" :value="__('Email')" /> -->
                    <label for="email" class="text-base font-semibold">Email Address</label>
                    <x-text-input id="email" class="form-input" style="background: url('{{ asset('assets/svgs/ic-email.svg') }}') no-repeat; background-position: 16px center;" type="email" name="email" :value="old('email')" placeholder="Your email address" required autofocus />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
        
                <div class="flex items-center justify-end mt-4">
                    <x-primary-button class="hover:bg-orange-600">
                        {{ __('Email Password Reset Link') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>