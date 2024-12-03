<x-app-layout>
    @if ($products->count() === 0)
        <div class="text-center text-gray-600 py-16 text-xl">
            There are no products published
        </div>
    @else
        <div class="grid gap-8 grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 p-5">
            @foreach($products as $product)
                <!-- Product Item -->
                <div class="border border-1 border-gray-200 rounded-md hover:border-purple-600 transition-colors bg-white flex flex-col">
                    <a href="{{ route('product.view', $product->slug) }}" class="aspect-w-3 aspect-h-2 block overflow-hidden">
                        <img src="{{ asset($product->image) }}" alt="" class="object-cover h-64 rounded-lg hover:scale-105 hover:rotate-1 transition-transform w-full" />
                    </a>
                    <div class="flex-grow p-4 flex flex-col justify-between">
                        <div>
                            <h3 class="text-lg mb-2">
                                <a href="{{ route('product.view', $product->slug) }}">
                                    {{ $product->title }}
                                </a>
                            </h3>
                            
                            <!-- Harga di atas tombol -->
                        </div>
                        <h5 class="font-bold mb-2">Rp. {{ $product->price }}</h5> <!-- Harga dipindahkan ke sini -->
                    </div>
                    
                    <!-- Tombol dengan padding lebih dan area hitbox 70%, efek hover abu-abu, dan rounded -->
                    <div class="py-3 px-4">
                        <button class="btn-primary w-7/10 mx-auto rounded-md transition-all hover:bg-gray-400 px-6 py-2" wire:click="addToCart({{ $product->id }})">
                            Add to Cart
                        </button>
                    </div>
                </div>
                <!--/ Product Item -->
            @endforeach
        </div>
        {{ $products->links() }}
    @endif
</x-app-layout>
