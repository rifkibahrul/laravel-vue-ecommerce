<x-app-layout>
    <section class="relative">
        @if ($products->count() === 0)
        <div class="text-center text-gray-600 py-16 text-xl">
            There are no products published
        </div>
        @else
        <div class="container mx-auto">
            <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 mt-12">
                @foreach($products as $product)
                <!-- Product Item -->
                <div
                    x-data="productItem({{ json_encode([
                            'id' => $product->id,
                            'slug' => $product->slug,
                            'image' => $product->first_image,
                            'title' => $product->title,
                            'price' => $product->price,
                            'addToCartUrl' => route('cart.add', $product),
                    ]) }})"
                    class="rounded-2xl bg-white shadow-lg hover:shadow-xl transition-shadow duration-300 flex flex-col"
                    x-init="formatRupiah = (value) => {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                    }">
                    <!-- Image -->
                    <a href="{{ route('product.view', $product->slug) }}" class="aspect-w-3 aspect-h-2 block overflow-hidden rounded-lg">
                        <!-- <img src="{{ asset($product->image) }}" alt="" class="object-cover h-52 rounded-lg hover:scale-105 hover:rotate-1 transition-transform w-full" /> -->
                        <img src="{{ $product->first_image ? asset($product->first_image) : asset('path/to/default-image.jpg') }}" alt="{{ $product->title }}" class="object-cover h-52 rounded-lg hover:scale-105 hover:rotate-1 transition-transform w-full" />
                    </a>
                    <div class="flex-grow p-4 flex flex-col justify-between">
                        <!-- Title -->
                        <div>
                            <h3 class="text-lg font-semibold w-[120px] truncate stretched-link block mb-2">
                                <a href="{{ route('product.view', $product->slug) }}">
                                    {{ $product->title }}
                                </a>
                            </h3>
                        </div>
                        <!-- Price -->
                        <h5 class="font-bold mb-1" x-text="formatRupiah({{ $product->price }})"></h5>
                    </div>

                    <div class="pb-3 px-4 flex justify-center">
                        <button class="mx-auto rounded-full px-6 py-2 bg-secondary text-white font-bold hover:bg-orange-600" @click="addToCart()">
                            Add to Cart <i class="ri-shopping-cart-2-line font-thin"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="px-6 mt-6">
                {{ $products->links() }}
            </div>
        </div>
        @endif
    </section>
</x-app-layout>