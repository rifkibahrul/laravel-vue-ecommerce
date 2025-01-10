<template>
    <div v-if="customer.id" class="animate-fade-in-down">
        <form @submit.prevent="onSubmit">
            <div class="bg-white px-4 pt-5 pb-4">
                <h1 class="text-2xl font-semibold pb-2">{{ title }}</h1>
                <CustomInput
                    class="mb-2"
                    v-model="customer.first_name"
                    label="First Name"
                />
                <CustomInput
                    class="mb-2"
                    v-model="customer.last_name"
                    label="Last Name"
                />
                <CustomInput
                    class="mb-2"
                    v-model="customer.email"
                    label="Email"
                />
                <CustomInput
                    class="mb-2"
                    v-model="customer.phone"
                    label="Phone"
                />
                <CustomInput
                    type="checkbox"
                    class="mb-2"
                    v-model="customer.status"
                    label="Active"
                />

                <div>
                    <h2
                        class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300"
                    >
                        Address
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2">
                        <CustomInput
                            v-model="customer.customerAddress.address"
                            label="Address"
                        />
                        <CustomInput
                            v-model="customer.customerAddress.city_name"
                            label="City"
                        />
                        <CustomInput
                            v-model="customer.customerAddress.province_name"
                            label="Province"
                        />
                        <CustomInput
                            v-model="customer.customerAddress.zipcode"
                            label="Zip Code"
                        />
                        <!-- 
                        <CustomInput
                            type="select"
                            :select-options="countries"
                            v-model="customer.customerAddress.country_code"
                            label="Country"
                        />
                        <CustomInput
                            v-if="!billingCountry.states"
                            v-model="customer.customerAddress.state"
                            label="State"
                        />
                        <CustomInput
                            v-else
                            type="select"
                            :select-options="billingStateOptions"
                            v-model="customer.customerAddress.state"
                            label="State"
                        /> -->
                    </div>
                </div>
            </div>
            <footer
                class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse"
            >
                <button
                    type="submit"
                    class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 text-base font-medium  focus:outline-none focus:ring-2 focus:ring-offset-2 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500"
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
const customerCity = computed(() => store.state.customerAddress);

function onSubmit() {
    loading.value = true;
    if (customer.value.id) {
        console.log(customer.value.status);
        customer.value.status =!! customer.value.status;
        store.dispatch("updateCustomer", customer.value).then((response) => {
            loading.value = false;
            if (response.status === 200) {
                // TODO show notification
                store.dispatch("getCustomers");
                router.push({ name: "app.customer" });
            }
        });
    } else {
        store
            .dispatch("createCustomer", customer.value)
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
                debugger;
            });
    }
}

onMounted(() => {
    store.dispatch("getCustomer", route.params.id).then(({ data }) => {
        title.value = `Update customer: "${data.first_name} ${data.last_name}"`;
        customer.value = data;
        customer.value.customerAddress = customer.value.customerAddress || {};
    });
});
</script>
