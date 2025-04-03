<x-app-layout>
    <section class="relative mt-12">
        <div x-data="productItem({{ json_encode([
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->first_image,
                        'title' => $product->title,
                        'price' => $product->price,
                        'addToCartUrl' => route('cart.add', $product),
                    ]) }})"
            x-init="formatRupiah = (value) => {
                        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
                    }"
            class="container mx-auto">
            <div class="grid gap-6 grid-cols-1 lg:grid-cols-5">
                <div class="lg:col-span-3">
                    <div
                        x-data="{
                            images: {{ json_encode($product->all_images) }}, // Ambil semua gambar dari accessor
                            activeImage: null,
                            prev() {
                                let index = this.images.indexOf(this.activeImage);
                                if (index === 0)
                                    index = this.images.length;
                                this.activeImage = this.images[index - 1];
                            },
                            next() {
                                let index = this.images.indexOf(this.activeImage);
                                if (index === this.images.length - 1)
                                    index = -1;
                                this.activeImage = this.images[index + 1];
                            },
                            init() {
                                this.activeImage = this.images.length > 0 ? this.images[0] : null;
                            }
                        }">
                        <!-- Main Image -->
                        <div class="relative">
                            <template x-for="image in images">
                                <div
                                    x-show="activeImage === image"
                                    class="aspect-w-3 aspect-h-2">
                                    <img :src="image" alt="" class="w-auto mx-auto" />
                                </div>
                            </template>
                            <a
                                @click.prevent="prev"
                                class="cursor-pointer bg-black/30 text-white absolute left-0 top-1/2 -translate-y-1/2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                            </a>
                            <a
                                @click.prevent="next"
                                class="cursor-pointer bg-black/30 text-white absolute right-0 top-1/2 -translate-y-1/2">
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        <!-- Sub Image -->
                        <div class="flex mt-1">
                            <template x-for="image in images">
                                <a
                                    @click.prevent="activeImage = image"
                                    class="cursor-pointer w-[80px] h-[80px] border border-neutral-200 hover:border-secondary flex items-center justify-center"
                                    :class="{'border-secondary rounded-md': activeImage === image}">
                                    <img :src="image" alt="" class="w-auto max-auto max-h-full" />
                                </a>
                            </template>
                        </div>
                    </div>
                </div>
                <div class="lg:col-span-2">
                    <h1 class="text-[25px] font-medium mb-2">
                        {{$product->title}}
                    </h1>
                    <h2 class="text-[20px] mb-6" x-text="formatRupiah({{ $product->price }})"></h2>
                    <div class="flex items-center justify-between mb-5">
                        <label for="quantity" class="block font-bold mr-4">
                            Quantity
                        </label>
                        <input
                            type="number"
                            name="quantity"
                            x-ref="quantityEl"
                            value="1"
                            min="1"
                            class="w-32 focus:border-purple-500 focus:outline-none rounded" />
                    </div>
                    <button
                        @click="addToCart($refs.quantityEl.value)"
                        class="py-4 text-lg flex justify-center min-w-0 w-full mb-6 rounded-full text-white bg-secondary hover:bg-orange-600">
                        <i class="ri-shopping-cart-2-line text-[25px] mr-2"></i>
                        Add to Cart
                    </button>
                    <div class="mb-6" x-data="{expanded: false}">
                        <div
                            x-show="expanded"
                            x-collapse.min.120px
                            class="text-gray-500 wysiwyg-content">
                            {{ $product->description }}
                        </div>
                        <p class="text-right">
                            <a
                                @click="expanded = !expanded"
                                href="javascript:void(0)"
                                class="text-purple-500 hover:text-secondary"
                                x-text="expanded ? 'Read Less' : 'Read More'"></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>