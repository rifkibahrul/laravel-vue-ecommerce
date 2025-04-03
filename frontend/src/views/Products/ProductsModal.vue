<!-- This example requires Tailwind CSS v2.0+ -->
<template>
    <TransitionRoot as="template" :show="show">
        <Dialog as="div" class="relative z-10" @close="show = false">
            <TransitionChild
                as="template"
                enter="ease-out duration-300"
                enter-from="opacity-0"
                enter-to="opacity-100"
                leave="ease-in duration-200"
                leave-from="opacity-100"
                leave-to="opacity-0"
            >
                <div
                    class="fixed inset-0 bg-black bg-opacity-70 transition-opacity"
                />
            </TransitionChild>

            <div class="fixed z-10 inset-0 overflow-y-auto">
                <div
                    class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0"
                >
                    <TransitionChild
                        as="template"
                        enter="ease-out duration-300"
                        enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        enter-to="opacity-100 translate-y-0 sm:scale-100"
                        leave="ease-in duration-200"
                        leave-from="opacity-100 translate-y-0 sm:scale-100"
                        leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    >
                        <DialogPanel
                            class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full"
                        >
                            <Spinner
                                v-if="loading"
                                class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"
                            />
                            <header
                                class="py-3 px-4 flex justify-between items-center"
                            >
                                <DialogTitle
                                    as="h3"
                                    class="text-lg leading-6 font-medium text-gray-900"
                                >
                                    {{
                                        product.id
                                            ? `Update product: "${props.product.title}"`
                                            : "Create new Product"
                                    }}
                                </DialogTitle>
                                <button
                                    @click="closeModal()"
                                    class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                        stroke="currentColor"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </header>
                            <form @submit.prevent="onSubmit">
                                <div class="bg-white px-4 pt-5 pb-4">
                                    <CustomInput
                                        class="mb-2"
                                        v-model="product.title"
                                        label="Product Title"
                                    />
                                    <!-- <CustomInput
                                        type="file"
                                        class="mb-2"
                                        label="Product Image"
                                        @change="
                                            (file) => (product.image = file)
                                        "
                                    /> -->
                                    <CustomInput
                                        type="file"
                                        class="mb-2"
                                        label="Product Images"
                                        multiple
                                        @change="handleImages"
                                    />
                                    <!-- Show preview of selected images -->
                                    <div
                                        v-if="
                                            product.images &&
                                            product.images.length
                                        "
                                        class="mb-4 grid grid-cols-3 gap-2"
                                    >
                                        <div
                                            v-for="(
                                                image, index
                                            ) in product.images"
                                            :key="index"
                                            class="relative"
                                        >
                                            <img
                                                :src="getImageUrl(image)"
                                                class="h-24 w-full object-cover rounded border"
                                            />
                                            <button
                                                type="button"
                                                @click="removeImage(index)"
                                                class="absolute top-1 right-1 bg-red-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs"
                                            >
                                                ×
                                            </button>
                                        </div>
                                    </div>
                                    <CustomInput
                                        type="textarea"
                                        class="mb-2"
                                        v-model="product.description"
                                        label="Description"
                                    />
                                    <!-- <CustomInput
                                        type="number"
                                        class="mb-2"
                                        v-model="product.price"
                                        label="Price"
                                        prepend="Rp"
                                        id="price"
                                    /> -->
                                    <div class="mb-2">
                                        <div
                                            class="mt-1 flex rounded-md shadow-sm"
                                        >
                                            <span
                                                class="inline-flex items-center px-3 rounded-l-md border border-r-0 border-gray-300 bg-gray-50 text-gray-500 text-sm"
                                            >
                                                Rp
                                            </span>
                                            <input
                                                type="text"
                                                v-model="displayPrice"
                                                @input="formatRupiahInput"
                                                @keydown="preventInvalidKeys"
                                                @paste="handlePaste"
                                                @blur="handleBlur"
                                                ref="priceInput"
                                                class="block w-full px-3 py-2 rounded-r-md border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                                                placeholder="Enter price"
                                            />
                                        </div>
                                    </div>
                                    <CustomInput
                                        type="checkbox"
                                        class="mb-2"
                                        v-model="product.published"
                                        label="Published"
                                    />
                                </div>
                                <footer
                                    class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
                                >
                                    <button
                                        type="submit"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
                                    >
                                        Submit
                                    </button>
                                    <button
                                        type="button"
                                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                                        @click="closeModal"
                                        ref="cancelButtonRef"
                                    >
                                        Cancel
                                    </button>
                                </footer>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { computed, ref, watch, nextTick } from "vue";
import {
    Dialog,
    DialogPanel,
    DialogTitle,
    TransitionChild,
    TransitionRoot,
} from "@headlessui/vue";
import { ExclamationIcon } from "@heroicons/vue/outline";
import CustomInput from "../../components/core/CustomInput.vue";
import store from "../../store/index.js";
import Spinner from "../../components/core/Spinner.vue";

// Helper function to handle different image formats
const convertToImageArray = (productData) => {
    if (Array.isArray(productData.images)) {
        return productData.images;
    }
    if (productData.image) {
        // Handle legacy single image format
        return [{ url: productData.image }];
    }
    return [];
};

const loading = ref(false);
const product = ref({
    id: "",
    title: "",
    images: [], // Now an array
    description: "",
    price: "",
    published: "",
});

const props = defineProps({
    modelValue: Boolean,
    product: {
        required: true,
        type: Object,
    },
});

const emit = defineEmits(["update:modelValue", "close"]);

const show = computed({
    get: () => props.modelValue,
    set: (value) => emit("update:modelValue", value),
});

// Safe image URL handling
const getImageUrl = (image) => {
    if (image instanceof File || image instanceof Blob) {
        return URL.createObjectURL(image);
    }
    if (image && image.url) {
        return image.url;
    }
    return image;
};

// Handle image selection
const handleImages = (files) => {
    if (!files) return;
    product.value.images = [
        ...product.value.images,
        ...Array.from(files).filter((file) => file instanceof File),
    ];
};

// Remove image by index
const removeImage = (index) => {
    product.value.images.splice(index, 1);
};

// price format
const displayPrice = ref("");
const priceInput = ref(null);
const error = ref('');

// watch change for props price
watch(
    () => props.product.price,
    (newValue) => {
        if (newValue || newValue === 0) {
            displayPrice.value = formatRupiah(newValue.toString(), "");
        } else {
            displayPrice.value = "";
        }
    },
    { immediate: true }
);

// Format rupiah function
const formatRupiah = (angka, prefix) => {
    if (!angka) {
        return "";
    }

    let number_string = angka.replace(/[^,\d]/g, "").toString();
    let split = number_string.split(",");
    let sisa = split[0].length % 3;
    let rupiah = split[0].substr(0, sisa);
    let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        let separator = sisa ? "." : "";
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
    return prefix === undefined ? rupiah : rupiah ? prefix + rupiah : "";
};

// Handle input formating
const formatRupiahInput = (e) => {
    error.value = "";
    const cursorPos = e.target.selectionStart;
    const formatted = formatRupiah(e.target.value, "");

    displayPrice.value = formatted;
    product.value.price = formatted
        ? parseInt(formatted.replace(/\./g, ""))
        : null;

    // Maintain cursor pointer
    nextTick(() => {
        const diff = displayPrice.value.length - e.target.value.length;
        priceInput.value.setSelectionRange(cursorPos + diff, cursorPos + diff);
    });
};

// Prevent invalid keys
const preventInvalidKeys = (e) => {
    // Allow: backspace, delete, tab, escape, enter, arrows, numbers, comma
    if (
        [46, 8, 9, 27, 13, 110, 188].includes(e.keyCode) ||
        (e.keyCode >= 35 && e.keyCode <= 40) ||
        (e.keyCode >= 48 && e.keyCode <= 57) ||
        (e.keyCode >= 96 && e.keyCode <= 105)
    ) {
        return;
    }
    e.preventDefault();
};

// Handle paste events
const handlePaste = (e) => {
    const pasteData = e.clipboardData.getData("text/plain");
    if (/\D/.test(pasteData)) {
        e.preventDefault();
        error.value = "Only numbers are allowed";
    }
};

// Handle blur to ensure proper formatting
const handleBlur = () => {
    if (displayPrice.value && !product.value.price) {
        error.value = "Please enter a valid number";
    }

    if (product.value.price) {
        displayPrice.value = formatRupiah(product.value.price.toString(), "");
    }
};

// Initialize product with props
watch(
    () => props.product,
    (newValue) => {
        product.value = {
            id: newValue.id,
            title: newValue.title,
            images: convertToImageArray(newValue),
            description: newValue.description,
            price: newValue.price,
            published: newValue.published,
        };
    },
    { immediate: true }
);

function closeModal() {
    show.value = false;
    emit("close");
}

function onSubmit() {
    loading.value = true;
    if (product.value.id) {
        store.dispatch("updateProduct", product.value).then((response) => {
            loading.value = false;
            if (response.status === 200) {
                store.dispatch("getProducts");
                closeModal();
            }
        });
    } else {
        store
            .dispatch("createProduct", product.value)
            .then((response) => {
                loading.value = false;
                if (response.status === 201) {
                    store.dispatch("getProducts");
                    closeModal();
                }
            })
            .catch((err) => {
                loading.value = false;
                console.error(err);
            });
    }
}
</script>
