<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
        <div class="flex justify-between border-b-2 pb-3">
            <!-- Show Products Per Page Start -->
            <div class="flex items-center">
                <span class="whitespace-nowrap mr-3">Per Page</span>
                <select
                    @change="getProducts(null)"
                    v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                >
                    <option value="5">5</option>
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="ml-3">Found {{ products.total }} products</span>
            </div>
            <!-- Show Products Per Page End -->

            <!-- Serach Bar Start  -->
            <div>
                <input
                    v-model="search"
                    @change="getProducts(null)"
                    class="appearance-none relative block w-48 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                    placeholder="... search product"
                />
            </div>
            <!-- Serach Bar End -->
        </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <TableHeaderCell
                        field="id"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @click="sortProducts('id')"
                    >
                        ID
                    </TableHeaderCell>
                    <TableHeaderCell
                        field="images"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                    >
                        Images
                    </TableHeaderCell>
                    <TableHeaderCell
                        field="title"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @click="sortProducts('title')"
                    >
                        Title
                    </TableHeaderCell>
                    <TableHeaderCell
                        field="price"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @click="sortProducts('price')"
                    >
                        Price
                    </TableHeaderCell>
                    <TableHeaderCell
                        field="updated_at"
                        :sort-field="sortField"
                        :sort-direction="sortDirection"
                        @click="sortProducts('updated_at')"
                    >
                        Last Updated At
                    </TableHeaderCell>
                    <TableHeaderCell field="action"> Action </TableHeaderCell>
                </tr>
            </thead>
            <tbody v-if="products.loading || !products.data.length">
                <tr>
                    <td colspan="6">
                        <Spinner v-if="products.loading" />
                        <p v-else class="text-center py-8 text-gray-700">
                            There are no products
                        </p>
                    </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-for="product of products.data" v-bind:key="product.id">
                    <td class="border-b p-2">{{ product.id }}</td>
                    <td class="border-b p-2">
                        <!-- <img
                            class="w-16 h-16 object-cover"
                            :src="product.image_url"
                            :alt="product.title"
                        /> -->
                        <div class="flex space-x-1 overflow-x-auto w-32">
                            <template
                                v-if="
                                    Array.isArray(product.images) &&
                                    product.images.length
                                "
                            >
                                <img
                                    v-for="(img, index) in product.images"
                                    :key="index"
                                    class="w-16 h-16 object-cover flex-shrink-0"
                                    :src="img.url"
                                    :alt="img.name || product.title"
                                />
                            </template>
                            <template v-else-if="product.image_url">
                                <!-- Fallback for legacy single image -->
                                <img
                                    class="w-16 h-16 object-cover"
                                    :src="product.image_url"
                                    :alt="product.title"
                                />
                            </template>
                            <!-- <template v-else>
                                <div
                                    class="w-16 h-16 bg-gray-200 flex items-center justify-center"
                                >
                                    <span class="text-xs text-gray-500"
                                        >No image</span
                                    >
                                </div>
                            </template> -->
                        </div>
                    </td>
                    <td
                        class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis"
                    >
                        {{ product.title }}
                    </td>
                    <td class="border-b p-2">
                        {{ formatRupiah(product.price) }}
                    </td>
                    <td class="border-b p-2">
                        {{ product.updated_at }}
                    </td>
                    <td class="border-b p-2">
                        <Menu as="div" class="relative inline-block text-left">
                            <div>
                                <MenuButton
                                    class="inline-flex items-center w-full justify-center rounded-full h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                                >
                                    <DotsVerticalIcon
                                        class="h-5 w-5 text-indigo-500"
                                        aria-hidden="true"
                                    />
                                </MenuButton>
                            </div>

                            <transition
                                enter-active-class="transition duration-100 ease-out"
                                enter-from-class="transform scale-95 opacity-0"
                                enter-to-class="transform scale-100 opacity-100"
                                leave-active-class="transition duration-75 ease-in"
                                leave-from-class="transform scale-100 opacity-100"
                                leave-to-class="transform scale-95 opacity-0"
                            >
                                <MenuItems
                                    class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                                >
                                    <div class="px-1 py-1">
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                    active
                                                        ? 'bg-indigo-600 text-white'
                                                        : 'text-gray-900',
                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                ]"
                                                @click="updateProduct(product)"
                                            >
                                                <PencilIcon
                                                    :active="active"
                                                    class="mr-2 h-5 w-5 text-indigo-400"
                                                    aria-hidden="true"
                                                />
                                                Edit
                                            </button>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                            <button
                                                :class="[
                                                    active
                                                        ? 'bg-indigo-600 text-white'
                                                        : 'text-gray-900',
                                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                                ]"
                                                @click="deleteProduct(product)"
                                            >
                                                <TrashIcon
                                                    :active="active"
                                                    class="mr-2 h-5 w-5 text-indigo-400"
                                                    aria-hidden="true"
                                                />
                                                Delete
                                            </button>
                                        </MenuItem>
                                    </div>
                                </MenuItems>
                            </transition>
                        </Menu>
                    </td>
                </tr>
            </tbody>
        </table>

        <!-- Pagination Start -->
        <div
            v-if="!products.loading"
            class="flex justify-between items-center mt-5"
        >
            <div v-if="products.data.length">
                Showing from {{ products.from }} to {{ products.to }}
            </div>
            <nav
                v-if="products.total > products.limit"
                class="relative z-0 inline-flex justify-center rounded-md shadow-sm -space-x-px"
                aria-label="Pagination"
            >
                <a
                    v-for="(link, i) of products.links"
                    :key="i"
                    :disabled="!link.url"
                    href="#"
                    @click="getForPage($event, link)"
                    aria-current="page"
                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium whitespace-nowrap"
                    :class="[
                        link.active
                            ? 'z-10 bg-indigo-50 border-indigo-500 text-indigo-600'
                            : 'bg-white border-gray-300 text-gray-500 hover:bg-gray-50',
                        i === 0 ? 'rounded-l-md' : '',
                        i === products.links.length - 1 ? 'rounded-r-md' : '',
                        !link.url ? ' bg-gray-100 text-gray-700' : '',
                    ]"
                    v-html="link.label"
                >
                </a>
            </nav>
        </div>
        <!-- Pagination End -->
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import store from "../../store";
import Spinner from "../../components/core/Spinner.vue";
import { PRODUCTS_PER_PAGE } from "../../constant";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import {
    DotsVerticalIcon,
    PencilIcon,
    TrashIcon,
} from "@heroicons/vue/outline";
import TableHeaderCell from "../../components/core/table/TableHeaderCell.vue";

const perPage = ref(PRODUCTS_PER_PAGE);
const search = ref("");
const products = computed(() => store.state.products);
const sortField = ref("updated_at");
const sortDirection = ref("desc");

const product = ref({});
const showProductModal = ref(false);

const emit = defineEmits(["clickEdit"]);

onMounted(() => {
    getProducts(); // Memuat data pertama kali
});

// Memanggil data produk dari bbackend
function getProducts(url = null) {
    store.dispatch("getProducts", {
        url,
        search: search.value,
        per_page: perPage.value,
        sort_field: sortField.value,
        sort_direction: sortDirection.value,
    });
}

// Sorting data
function sortProducts(field) {
    if (field === sortField.value) {
        if (sortDirection.value === "desc") {
            sortDirection.value = "asc";
        } else {
            sortDirection.value = "desc";
        }
    } else {
        sortField.value = field;
        sortDirection.value = "asc";
    }

    getProducts();
}

// Pagination
function getForPage(ev, link) {
    ev.preventDefault();
    if (!link.url || link.active) {
        return;
    }
    getProducts(link.url);
}

function showAddNewModal() {
    showProductModal.value = true;
}

// Edit data
function updateProduct(p) {
    emit("clickEdit", p);
}

function formatRupiah(value) {
    if (!value) return "Rp0";
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
    }).format(value);
}

function deleteProduct(product) {
    if (!confirm(`Are you sure you want to delete the product?`)) {
        return;
    }
    store.dispatch("deleteProduct", product.id).then((res) => {
        // TODO NOTIFICATION
        store.dispatch("getProducts");
    });
}
</script>
