<x-app-layout>
    <div class="flex flex-col items-center px-6 py-10">
        <!-- Logo -->
        <img src="{{ asset('assets/images/Logo.svg') }}" alt="logo" class="mb-[53px]">

        <!-- Form -->
        <form method="POST" action="{{ route('register') }}" class="mx-auto max-w-[345px] w-full p-6 bg-white rounded-3xl">
            <div class="flex flex-col gap-5">
                <p class="text-[25px] font-bold">
                    New Account
                </p>
                @csrf
    
                <!-- Name -->
                <div class="flex flex-col gap-2.5">
                    <!-- <x-input-label for="name" :value="__('Name')" /> -->
                    <label for="name" class="text-base font-semibold">Username</label>
                    <x-text-input id="name" class="form-input" style="background: url('{{ asset('assets/svgs/ic-profile.svg') }}') no-repeat; background-position: 16px center;" type="text" name="name" :value="old('name')" required autocomplete="name" placeholder="Write your username" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>
    
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
                    <x-text-input id="password" class="form-input"
                        type="password"
                        name="password"
                        style="background: url('{{ asset('assets/svgs/ic-lock.svg') }}') no-repeat; background-position: 16px center;"
                        required autocomplete="new-password" 
                        placeholder="Protect your password"/>
    
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
    
                <!-- Confirm Password -->
                <div class="flex flex-col gap-2.5">
                    <!-- <x-input-label for="password_confirmation" :value="__('Confirm Password')" /> -->
                    <label for="password_confirmation" class="text-base font-semibold">Confirm Password</label>
    
                    <x-text-input id="password_confirmation" class="form-input"
                        type="password"
                        name="password_confirmation" 
                        style="background: url('{{ asset('assets/svgs/ic-lock.svg') }}') no-repeat; background-position: 16px center;"
                        required autocomplete="new-password" 
                        placeholder="Protect your password"/>
    
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>
    
                <x-primary-button class="hover:bg-orange-600">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
        <div class="flex items-center justify-end mt-4">
            <a class="font-semibold text-lg mt-[30px] underline hover:text-secondary" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
        <!-- <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
        </div> -->
    </div>
</x-app-layout>