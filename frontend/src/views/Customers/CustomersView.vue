<template>
    <div v-if="customer.id" class="animate-fade-in-down">
        <form @submit.prevent="onSubmit">
            <div class="bg-white px-4 pt-5 pb-4">
                <!-- Judul Form -->
                <h1 class="text-2xl font-semibold pb-2">{{ title }}</h1>

                <!-- Informasi Dasar -->
                <label
                    for="name"
                    class="block text-sm font-medium text-gray-700"
                >
                    Name
                </label>
                <CustomInput
                    class="mb-2"
                    v-model="customer.name"
                    label="Name"
                />
                <label
                    for="first_name"
                    class="block text-sm font-medium text-gray-700"
                >
                    First Name
                </label>
                <CustomInput
                    class="mb-2"
                    v-model="customer.first_name"
                    label="First Name"
                />
                <label
                    for="last_name"
                    class="block text-sm font-medium text-gray-700"
                >
                    Last Name
                </label>
                <CustomInput
                    class="mb-2"
                    v-model="customer.last_name"
                    label="Last Name"
                />
                <label
                    for="email"
                    class="block text-sm font-medium text-gray-700"
                >
                    Email
                </label>
                <CustomInput
                    class="mb-2"
                    v-model="customer.email"
                    label="Email"
                />
                <label
                    for="phone"
                    class="block text-sm font-medium text-gray-700"
                >
                    Phone Number
                </label>
                <CustomInput
                    class="mb-2"
                    v-model="customer.phone"
                    label="Phone"
                />
                <label
                    for="status"
                    class="block text-sm font-medium text-gray-700"
                >
                    Status Account
                </label>
                <CustomInput
                    type="checkbox"
                    class="mb-2"
                    v-model="customer.status"
                    label="Active"
                />

                <!-- Alamat -->
                <div>
                    <h2
                        class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300"
                    >
                        Address Detail
                    </h2>

                    <div
                        class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2 mt-3"
                    >
                        <div>
                            <label
                                for="address"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Address
                            </label>
                            <CustomInput
                                id="address"
                                v-model="customer.customerAddress.address"
                                label="Address"
                                class="w-full rounded-md border-gray-300"
                            />
                        </div>
                        <div>
                            <label
                                for="zipcode"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Zip Code
                            </label>
                            <CustomInput
                                id="zipcode"
                                v-model="customer.customerAddress.zipcode"
                                label="Zip Code"
                                class="w-full rounded-md border-gray-300"
                            />
                        </div>
                        <div>
                            <label
                                for="province"
                                class="block text-sm font-medium text-gray-700"
                            >
                                Province
                            </label>
                            <select
                                id="province"
                                v-model="customer.customerAddress.province_id"
                                @change="
                                    fetchCities(
                                        customer.customerAddress.province_id
                                    )
                                "
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            >
                                <option value="" disabled>
                                    Select Province
                                </option>
                                <option
                                    v-for="province in provinces"
                                    :key="province.province_id"
                                    :value="province.province_id"
                                >
                                    {{ province.province }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <label
                                for="city"
                                class="block text-sm font-medium text-gray-700"
                            >
                                City
                            </label>
                            <select
                                id="city"
                                v-model="customer.customerAddress.city_id"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                            >
                                <option value="" disabled>Select City</option>
                                <option
                                    v-for="city in cities"
                                    :key="city.city_id"
                                    :value="city.city_id"
                                >
                                    {{ city.city_name }}
                                </option>
                            </select>
                        </div>
                    </div>
                </div>
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
                <router-link
                    :to="{ name: 'app.customer' }"
                    type="button"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    ref="cancelButtonRef"
                >
                    Cancel
                </router-link>
            </footer>
        </form>
    </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import store from "../../store";
import { useRoute, useRouter } from "vue-router";
import axiosClient from "../../axios";
import CustomInput from "../../components/core/CustomInput.vue";

const route = useRoute();
const router = useRouter();
const title = ref("");
const customer = ref({
    customerAddress: {},
});

const loading = ref(false);
const provinces = ref([]);
const cities = ref([]);

function fetchProvinces() {
    axiosClient.get("/provinces").then((response) => {
        provinces.value = response.data;
    });
}

function fetchCities(provinceId) {
    if (!provinceId) {
        cities.value = [];
        return;
    }

    axiosClient
        .get(`/cities?province_id=${provinceId}`)
        .then((response) => {
            cities.value = response.data;
        })
        .catch((error) => {
            console.error("Error fetching cities: ", error);
        });
}

function onSubmit() {
    loading.value = true;

    // set province_name dan city_name berdasarkan ID yang dipilih
    const selectedProvince = provinces.value.find(
        (p) => p.province_id === customer.value.customerAddress.province_id
    );
    const selectedCity = cities.value.find(
        (c) => c.city_id === customer.value.customerAddress.city_id
    );

    customer.value.customerAddress.province_name =
        selectedProvince?.province || "";
    customer.value.customerAddress.city_name = selectedCity?.city_name || "";

    const data = {
        id: customer.value.id,
        name: customer.value.name,
        email: customer.value.email,
        first_name: customer.value.first_name,
        last_name: customer.value.last_name,
        phone: customer.value.phone,
        status: customer.value.status,
        address: customer.value.customerAddress.address,
        province_id: customer.value.customerAddress.province_id,
        city_id: customer.value.customerAddress.city_id,
        province_name: customer.value.customerAddress.province_name,
        city_name: customer.value.customerAddress.city_name,
        zipcode: customer.value.customerAddress.zipcode,
    };
    // console.log(data);
    
    if (customer.value.id) {
        // console.log(customer.value.status);
        customer.value.status = !!customer.value.status;
        store.dispatch("updateCustomer", data).then((response) => {
            loading.value = false;
            if (response.status === 200) {
                // TODO show notification
                store.dispatch("getCustomers");
                router.push({ name: "app.customer" });
            }
        });
    } else {
        store
            .dispatch("createCustomer", data)
            .then((response) => {
                loading.value = false;
                if (response.status === 201) {
                    // TODO show notification
                    store.dispatch("getCustomers");
                    router.push({ name: "app.customer" });
                }
            })
            .catch((err) => {
                loading.value = false;
                // debugger;
            });
    }
}

onMounted(() => {
    fetchProvinces();
    store.dispatch("getCustomer", route.params.id).then(({ data }) => {
        title.value = `Update customer: "${data.first_name} ${data.last_name}"`;
        customer.value = data;
        // console.log(customer.value.status);
        customer.value.customerAddress = customer.value.customerAddress || {};
        if (customer.value.customerAddress.province_id) {
            fetchCities(customer.value.customerAddress.province_id);
        }
    });
});
</script>
