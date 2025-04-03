<x-app-layout>
    <div class="container lg:w-2/3 xl:w-2/3 mx-auto">
        <h1 class=" text-3xl font-bold mb-6 mt-6">Cart Items</h1>

        <div
            x-data="{ 
                cartItems: {{ 
                    json_encode(
                        $products->map(fn($product) => [
                            'id' => $product->id,
                            'slug' => $product->slug,
                            'image' => $product->first_image,
                            'title' => $product->title,
                            'price' => $product->price,
                            'quantity' => $cartItems[$product->id]['quantity'],
                            'href' => route('product.view', $product->slug),
                            'removeUrl' => route('cart.remove', $product),
                            'updateQuantityUrl' => route('cart.update-quantity', $product)
                        ])
                    )
                }},
                get cartTotal() {
                    return this.cartItems.reduce((accum, next) => accum + next.price * next.quantity, 0).toFixed(2)
                },
                formatRupiah(value) {
                    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                }
            }"
            class="bg-slate-200 p-4 rounded-lg shadow">

            <!-- Tabbel Product Items Start -->
            <template x-if="cartItems.length">
                <div>
                    <!-- Daftar Item Start -->
                    <template x-for="product of cartItems" :key="product.id">
                        <div x-data="productItem(product)">
                            <div class="w-full flex flex-col sm:flex-row items-center gap-4 flex-1">
                                <!-- Gambar Produk Start -->
                                <a :href="product.href" class="w-36 h-32 flex items-center justify-center overflow-hidden">
                                    <img :src="product.image" alt="" class="object-cover" />
                                </a>
                                <!-- Gambar Produk End -->

                                <!-- Detail Produk Start -->
                                <div class="flex flex-col justify-between flex-1">
                                    <!-- Judul dan Harga Start -->
                                    <div class="flex justify-between mb-3">
                                        <h3 x-text="product.title"></h3>
                                        <div class="text-lg font-semibold flex items-center">
                                            <span x-text="formatRupiah(product.price)" class="ml-1"></span>
                                        </div>
                                    </div>
                                    <!-- Judul dan Harga End -->

                                    <!-- Jumlah Start -->
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            Jumlah:
                                            <input
                                                type="number"
                                                min="1"
                                                x-model="product.quantity"
                                                @change="changeQuantity()"
                                                class="ml-3 py-1 border-gray-200 focus:border-purple-600 focus:ring-purple-600 w-16">
                                        </div>
                                        <a href="#" @click.prevent="removeItemFromCart()" class="text-purple-600 hover:text-purple-500">Remove</a>
                                    </div>
                                    <!-- Jumlah End -->
                                </div>
                                <!-- Detail Produk End -->
                            </div>
                            <hr class="my-5">
                        </div>
                    </template>
                    <!-- Daftar Item End -->
                    <!-- Checkout Start -->
                    <div class="border-t border-gray-3 pt-4">
                        <div class="flex justify-between mb-6">
                            <span class="font-semibold">Subtotal</span>
                            <span id="cartTotal" class="text-xl" x-text="formatRupiah(cartTotal)"></span>
                        </div>
                        <a href="{{ route('checkout.index') }}" class="btn-primary w-full py-3 text-lg hover:bg-white text-center block">
                            Checkout
                        </a>
                    </div>
                    <!-- Checkout End -->
                </div>
            </template>
            <!-- Tabbel Product Items End -->
            <template x-if="!cartItems.length">
                <div class="text-center py-8 text-gray-500">
                    You don't have any items in cart
                </div>
            </template>
        </div>
    </div>
</x-app-layout>