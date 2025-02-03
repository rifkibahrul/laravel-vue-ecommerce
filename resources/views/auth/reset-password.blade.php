<x-guest-layout>
    <form method="POST" action="{{ route('password.store') }}" class="mx-auto max-w-[345px] w-full p-6 bg-white rounded-3xl">
        <div class="flex flex-col gap-5">
            <p class="text-[25px] font-bold">
                Reset Password
            </p>
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="flex flex-col gap-2.5">
                <!-- <x-input-label for="email" :value="__('Email')" /> -->
                <label for="email" class="text-base font-semibold">Email Address</label>
                <x-text-input id="email" class="form-input" style="background: url('{{ asset('assets/svgs/ic-email.svg') }}') no-repeat; background-position: 16px center;" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-2.5">
                <!-- <x-input-label for="password" :value="__('Password')" /> -->
                <label for="password" class="text-base font-semibold">Password</label>
                <x-text-input id="password" class="form-input" style="background: url('{{ asset('assets/svgs/ic-lock.svg') }}') no-repeat; background-position: 16px center;" type="password" name="password" required autocomplete="new-password" placeholder="New password"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="flex flex-col gap-2.5">
                <!-- <x-input-label for="password_confirmation" :value="__('Confirm Password')" /> -->
                <label for="password_confirmation" class="text-base font-semibold">Confirm Password</label>

                <x-text-input id="password_confirmation" 
                    class="form-input" 
                    style="background: url('{{ asset('assets/svgs/ic-lock.svg') }}') no-repeat; background-position: 16px center;"
                    type="password"
                    name="password_confirmation" required autocomplete="new-password" placeholder="New password"/>

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="hover:bg-orange-600">
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>