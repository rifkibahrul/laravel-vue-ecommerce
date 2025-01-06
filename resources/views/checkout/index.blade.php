<x-app-layout>
    <div class="container mx-auto px-4 max-w-6xl">
        <h1 class="text-3xl font-bold mb-6 mt-6">Checkout</h1>
        <div class="flex flex-wrap lg:flex-nowrap justify-center mt-6 gap-4">
            <!-- Bagian Kiri -->
            <div class="w-full lg:w-1/2 p-4 bg-slate-400 rounded-md">
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 p-2">
                        <x-input-label for="first_name" :value="__('First Name')" />
                        <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="$customer->first_name" disabled />
                        <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                    </div>
                    <div class="w-full sm:w-1/2 p-2">
                        <x-input-label for="last_name" :value="__('Last Name')" />
                        <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="$customer->last_name" disabled />
                        <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                    </div>
                </div>
                <div class="w-full p-2">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="text" class="mt-1 block w-full" :value="auth()->user()->email" disabled />
                    <x-input-error class="mt-2" :messages="$errors->get('email')" />
                </div>
                <div class="w-full p-2">
                    <x-input-label for="address" :value="__('Address')" />
                    <x-text-input id="address" name="address" type="text" class="mt-1 block w-full" :value="$customerAddress->address" disabled />
                    <x-input-error class="mt-2" :messages="$errors->get('address')" />
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 p-2">
                        <x-input-label for="province" :value="__('Provinsi')" />
                        <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" :value="$customerAddress->province_name" disabled />
                        <x-input-error class="mt-2" :messages="$errors->get('province')" />
                    </div>
                    <div class="w-full sm:w-1/2 p-2">
                        <x-input-label for="city" :value="__('Kab/Kota')" />
                        <x-text-input id="city" name="city" type="text" class="mt-1 block w-full" :value="$customerAddress->city_name" disabled />
                        <x-input-error class="mt-2" :messages="$errors->get('city')" />
                    </div>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full sm:w-1/2 p-2">
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="$customer->phone" disabled />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>
                    <div class="w-full sm:w-1/2 p-2">
                        <x-input-label for="zipcode" :value="__('Zipcode')" />
                        <x-text-input id="zipcode" name="zipcode" type="text" class="mt-1 block w-full" :value="$customerAddress->zipcode" disabled />
                        <x-input-error class="mt-2" :messages="$errors->get('zipcode')" />
                    </div>
                </div>
            </div>

            <!-- Bagian Kanan -->
            <div class="w-full lg:w-1/2 p-4 bg-slate-200 rounded-md" x-data="payments" x-init="init" x-subtotal="{{ $subtotal }}">
                <div class="mt-2">
                    <x-input-label for="delivery" :value="__('Delivery Option')" />
                    <select
                        @change="getDeliveryCost($event)"
                        id="delivery"
                        name="delivery"
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                        <option value="">{{ __('Select Delivery') }}</option>
                        @foreach ($listCost as $cost)
                        <option value="{{ $cost['cost'][0]['value'] }}__{{ $cost['service'] }}">
                            JNE {{ $cost['service'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="mt-3">
                    <div class="card bg-white p-4 w-full">
                        <h2 class="font-bold text-lg mb-4">Cart Total</h2>
                        <div class="checkout-detail">
                            <p class="flex justify-between mb-2">
                                <span>Subtotal Barang</span>
                                <span>{{ $formattedTotal }}</span>
                            </p>
                            <div x-show="deliveryCost > 0">
                                <!-- <span>Delivery Kurir</span> -->
                                <p id="delivery-cost"></p>
                            </div>
                        </div>
                        <div class="flex-grow border-t border-gray-400 mt-1 mb-1"></div>
                        <p class="flex justify-between mt-4 mb-4">
                            <span>Total Keseluruhan</span>
                            <span class="font-semibold" id="total"></span>
                        </p>

                        <button @click="processPayment()" :disabled="isProcessing" type="button" id="pay-btn" class="bg-sky-500 py-3 w-full rounded-full hover:bg-sky-700 hover:text-white flex items-center justify-center">
                            <svg x-show="isProcessing" class="animate-spin h-5 w-5 mr-3 border-4 border-gray-200 rounded-full border-t-gray-600" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="10" fill="none" stroke-width="2" stroke-linecap="round" />
                            </svg>
                            <span x-show="!isProcessing">Submit</span>
                            <span x-show="isProcessing">Processing...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="finish-form" action="{{ route('checkout.finish') }}" method="post" style="display: hidden;">
        @csrf
        <input type="hidden" name="result-data">
        <input type="hidden" name="delivery-cost">
        <input type="hidden" name="delivery-service">
    </form>
</x-app-layout>


<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>