<x-app-layout>
    <div class="container mx-auto px-4 max-w">
        <h1 class=" text-3xl font-bold mb-6 mt-6">Detail Order</h1>

        <div class="flex flex-wrap lg:flex-nowrap mt-6 gap-4">

            <!-- Sebelah Kiri Start -->
            <div class="w-full lg:w-1/2 p-4 rounded-md">
                <div class="bg-white rounded shadow-md p-4 mb-4">
                    <ul>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Status</strong>
                            <small
                                class="py-1 px-2 rounded capitalize
                            {{ strtolower($order->status) === 'settlement' ? 'badge-green' : (strtolower($order->status) === 'pending' ? 'badge-yellow' : 'badge-red') }}">
                                {{ $order->status }}
                            </small>
                        </li>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Order Date</strong>
                            <span>{{ $order->created_at }}</span>
                        </li>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Serial Order</strong>
                            <span>{{ $payment->serial_number }}</span>
                        </li>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Customer Name</strong>
                            <span>{{ $userData['customer']->first_name }}</span>
                        </li>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Payment Type</strong>
                            <span> {{ $payment->payment_type }} </span>
                        </li>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Payment Code / VA Number</strong>
                            <span> {{ $payment->payment_code }} </span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white rounded shadow-md p-4">
                    <ul>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Delivery</strong>
                            <span>JNE {{ $payment->delivery_service }}</span>
                        </li>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Delivery Cost</strong>
                            <span>Rp {{ number_format($payment->delivery_cost, 2, ',', '.') }}</span>
                        </li>
                        <li class="flex justify-between py-2 border-b border-gray-200">
                            <strong>Total</strong>
                            <span class="text-2xl font-semibold">Rp {{ number_format($order->total_price, 2, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Sebelah Kiri End -->

            <!-- Sebelah Kanan Start -->
            <div class="w-full lg:w-1/2 p-4 rounded-md">
                @if($detail['message'] != '')
                <div class="bg-white rounded shadow-md p-4 mb-4">
                    <h3 class="text-lg font-semibold">
                        {{ $detail['message'] }}
                    </h3>
                    @if($detail['pdf_url'] != '')
                    <h4 class="text-md mt-2 mb-2">You can get step by step payment here</h4>
                    <div class="mt-4 mb-4">
                        <a class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" href="{{ $detail['pdf_url'] }}" target="_blank">Download Instructions</a>
                    </div>
                    @endif
                </div>
                @endif
                <div class="bg-white rounded shadow-md p-4">
                    <strong>List Item</strong>
                    <!-- List Item -->
                    <div class="flex flex-col gap-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center p-4 gap-4">
                            <!-- Gambar Produk -->
                            <a href="#" class="w-24 h-24 flex items-center justify-center overflow-hidden">
                                <img src="{{ $item->product->image }}" alt="/" class="w-full h-full object-cover">
                            </a>
                            <!-- Detail Produk -->
                            <div class="flex flex-col justify-between flex-1">
                                <h3>
                                    {{ $item->product->title }}
                                </h3>
                                <div class="flex justify-between items-center">
                                    <span class="text-sm">Jumlah: {{ $item->quantity }}</span>
                                    <span class="text-lg font-semibold">Rp {{ number_format($item->unit_price * $item->quantity, 2, ',', '.') }}</span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Sebelah Kanan End -->
        </div>
    </div>
</x-app-layout>