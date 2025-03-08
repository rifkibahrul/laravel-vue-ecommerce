<x-app-layout>
    <section class="relative mt-12 pb-12 md:container md:mx-auto md:px-4 md:max-w">
        <h1 class="text-3xl font-bold mx-[25px] md:mx-0 mb-4">Detail Order</h1>
        <div class="flex flex-wrap mx-[25px] md:mx-0 lg:flex-nowrap md:mt-6 md:gap-4">

            <!-- Sebelah Kiri Start -->
            <div class="w-full lg:w-1/2 rounded-xl">
                <div class="bg-white rounded shadow-md p-4 mb-4">
                    <ul>
                        <li class="flex flex-col md:flex-row md:justify-between py-2 border-b border-gray-200">
                            <strong>Status</strong>
                            <small
                                class="py-1 px-2 rounded capitalize
                            {{ strtolower($order->status) === 'settlement' ? 'badge-green' : (strtolower($order->status) === 'pending' ? 'badge-yellow' : 'badge-red') }}">
                                {{ $order->status }}
                            </small>
                        </li>
                        <li class="flex flex-col md:flex-row md:justify-between py-2 border-b border-gray-200">
                            <strong>Order Date</strong>
                            <span>{{ $order->created_at }}</span>
                        </li>
                        <li class="flex flex-col md:flex-row md:justify-between py-2 border-b border-gray-200">
                            <strong>Serial Order</strong>
                            <span>{{ $payment->serial_number }}</span>
                        </li>
                        <li class="flex flex-col md:flex-row md:justify-between py-2 border-b border-gray-200">
                            <strong>Customer Name</strong>
                            <span>{{ $userData['customer']->first_name }}</span>
                        </li>
                        <li class="flex flex-col md:flex-row md:justify-between py-2 border-b border-gray-200">
                            <strong>Payment Type</strong>
                            <span> {{ $payment->payment_type }} </span>
                        </li>
                        <li class="flex flex-col md:flex-row md:justify-between py-2 border-b border-gray-200">
                            <strong>Payment Code / VA Number</strong>
                            <span> {{ $payment->payment_code }} </span>
                        </li>
                    </ul>
                </div>
                <div class="bg-white rounded shadow-md p-4">
                    <ul>
                        <li class="flex flex-col md:flex-row justify-between py-2 border-b border-gray-200">
                            <strong>Delivery</strong>
                            <span>JNE {{ $payment->delivery_service }}</span>
                        </li>
                        <li class="flex flex-col md:flex-row justify-between py-2 border-b border-gray-200">
                            <strong>Delivery Cost</strong>
                            <span>Rp {{ number_format($payment->delivery_cost, 2, ',', '.') }}</span>
                        </li>
                        <li class="flex flex-col md:flex-row justify-between py-2 border-b border-gray-200">
                            <strong>Total</strong>
                            <span class="text-2xl font-semibold">Rp {{ number_format($order->total_price, 2, ',', '.') }}</span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Sebelah Kiri End -->

            <!-- Sebelah Kanan Start -->
            <div class="w-full lg:w-1/2 mt-4 md:mt-0 rounded-xl">
                <div class="bg-white rounded shadow-md p-4 mb-4">
                    <strong>List Item</strong>
                    <!-- List Item -->
                    <div class="flex flex-col md:gap-4">
                        @foreach($order->items as $item)
                        <div class="flex items-center gap-2 p-2 relative md:p-4 md:gap-4">
                            <!-- Gambar Produk -->
                            <a href="#" class="w-16 h-16 flex items-center justify-center overflow-hidden md:w-24 md:h-24">
                                <img src="{{ $item->product->image }}" alt="/" class="w-full h-full object-cover">
                            </a>
                            <!-- Detail Produk -->
                            <div class="flex flex-col flex-1">
                                <!-- <div class="flex flex-col gap-1"> -->
                                <div class="flex flex-col md:gap-1">
                                    <!-- <h3 class="stretched-link whitespace-nowrap ml-1 sm:w-full sm:truncate sm:whitespace-normal"> -->
                                    <!-- Harga Produk -->
                                    <h3 class="whitespace-nowrap truncate w-[280px] sm:w-full sm:whitespace-normal sm:overflow-auto">
                                        {{ $item->product->title }}
                                    </h3>
                                    <!-- Kuantitas Produk -->
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm">Jumlah: {{ $item->quantity }}</span>
                                        <span class="text-lg font-semibold">Rp {{ number_format($item->unit_price * $item->quantity, 2, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @if($detail['message'] != '')
                <div class="bg-white rounded shadow-md p-4">
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

            </div>
            <!-- Sebelah Kanan End -->
        </div>
    </section>
</x-app-layout>