<template>
    <div>
        <div class="mb-2 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Dashboard</h1>
            <div class="flex items-center">
                <label class="mr-2">Change Date Period</label>
                <CustomInput
                    type="select"
                    v-model="chosenDate"
                    @change="onDatePickerChange"
                    :select-options="dateOptions"
                />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
            <!-- Customer Count Start -->
            <div
                class="bg-white py-6 px-5 rounded-lg shadow-md flex flex-col items-center justify-center animate-fade-in-down"
            >
                <label for="" class="text-lg font-semibold block mb-2"
                    >Active Customer</label
                >

                <template v-if="!loading.customersCount">
                    <span class="text-lg font-semibold block mb-2">{{
                        customersCount
                    }}</span>
                </template>
                <Spinner v-else text="" class="" />
            </div>
            <!-- Customer Count End -->
            <!-- Products Count Start -->
            <div
                class="bg-white py-6 px-5 rounded-lg shadow-md flex flex-col items-center justify-center animate-fade-in-down"
                style="animation-delay: 0.1s"
            >
                <label for="" class="text-lg font-semibold block mb-2"
                    >Active Products</label
                >

                <template v-if="!loading.productsCount">
                    <span class="text-lg font-semibold block mb-2">{{
                        productsCount
                    }}</span>
                </template>
                <Spinner v-else text="" class="" />
            </div>
            <!-- Products Count End -->

            <!-- Paid Order Start -->
            <div
                class="bg-white py-6 px-5 rounded-lg shadow-md flex flex-col items-center justify-center animate-fade-in-down"
                style="animation-delay: 0.2s"
            >
                <label for="" class="text-lg font-semibold block mb-2"
                    >Orders Success</label
                >

                <template v-if="!loading.paidOrders">
                    <span class="text-lg font-semibold block mb-2">{{
                        paidOrders
                    }}</span>
                </template>
                <Spinner v-else text="" class="" />
            </div>
            <!-- Paid Order End -->

            <!-- Total Income Start -->
            <div
                class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center animate-fade-in-down"
                style="animation-delay: 0.3s"
            >
                <label for="" class="text-lg font-semibold block mb-2"
                    >Total Income</label
                >

                <template v-if="!loading.totalIncome">
                    <span class="text-lg font-semibold block mb-2">{{
                        totalIncome
                    }}</span>
                </template>
                <Spinner v-else text="" class="" />
            </div>
            <!-- Total Income End -->
        </div>

        <div
            class="grid grid-rows-1 md:grid-rows-2 md:grid-flow-col grid-cols-1 md:grid-cols-3 gap-3"
        >
            <!-- Latest Order Start -->
            <div
                class="bg-white col-span-1 md:col-span-2 row-span-1 md:row-span-2 py-6 px-5 rounded-lg shadow"
            >
                <label class="text-lg font-semibold block mb-2"
                    >Latest Order</label
                >
                <template v-if="!loading.latestOrders">
                    <div
                        v-for="order of latestOrders"
                        :key="order.id"
                        class="py-2 px-3 hover:bg-gray-50"
                    >
                        <p>
                            <router-link
                                :to="{
                                    name: 'app.order.view',
                                    params: { id: order.id },
                                }"
                            >
                                Order ID {{ order.id }}
                            </router-link>
                        </p>
                        <p class="flex justify-between">
                            <span
                                >{{ order.first_name }}
                                {{ order.last_name }}</span
                            >
                            <span>{{
                                $filters.currencyRP(order.total_price)
                            }}</span>
                        </p>
                    </div>
                </template>
                <Spinner v-else text="" class="" />
            </div>
            <!-- Latest Order End -->

            <!-- Order Per City Chart Start  -->
            <div
                class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center"
            >
                <label for="" class="text-lg font-semibold block mb-2"
                    >Orders per City</label
                >
                <template v-if="!loading.orderByCity">
                    <DoughnutChart
                        :width="140"
                        :height="120"
                        :data="orderByCity"
                    />
                </template>
                <Spinner v-else text="" class="" />
            </div>
            <!-- Order Per City Chart End  -->

            <!-- Lates Customer Start -->
            <div class="bg-white py-6 px-5 rounded-lg shadow">
                <label for="" class="text-lg font-semibold block mb-2">Latest Customers</label>
                <template v-if="!loading.latestCustomers">
                    <router-link :to="{ name: 'app.customer.view', params: { id: customer.id } }" v-for="customer of latestCustomers" :key="customer.id" class="mb-3 flex">
                        <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-full mr-2">
                            <UserIcon class="w-5" />
                        </div>
                        <div>
                            <h3>{{ customer.first_name }} {{ customer.last_name }}</h3>
                            <p>{{ customer.email }}</p>
                        </div>
                    </router-link>
                </template>
                <Spinner v-else text="" class=""/>
            </div>
            <!-- Lates Customer End -->
        </div>
    </div>
</template>

<script setup>
import { UserIcon } from "@heroicons/vue/outline";
import axiosClient from "../axios.js";
import DoughnutChart from "../components/core/charts/Doughnut.vue";
import { computed, onMounted, ref } from "vue";
import Spinner from "../components/core/Spinner.vue";
import CustomInput from "../components/core/CustomInput.vue";
import { useStore } from "vuex";

const store = useStore();
const dateOptions = computed(() => store.state.dateOptions);
const chosenDate = ref("all");

const loading = ref({
    customersCount: true,
    productsCount: true,
    paidOrders: true,
    totalIncome: true,
    latestCustomers: true,
    latestOrders: true,
    orderByCity: true,
});

const customersCount = ref(0);
const productsCount = ref(0);
const paidOrders = ref(0);
const totalIncome = ref(0);
const latestOrders = ref([]);
const latestCustomers = ref([]);
const orderByCity = ref([]);

function updateDashboard() {
    const d = chosenDate.value;
    loading.value = {
        customersCount: true,
        productsCount: true,
        paidOrders: true,
        totalIncome: true,
        latestOrders: true,
        latestCustomers: true,
        orderByCity: true,
    };
    axiosClient
        .get(`/dashboard/customers-count`, { params: { d } })
        .then(({ data }) => {
            customersCount.value = data;
            loading.value.customersCount = false;
        });
    axiosClient
        .get(`/dashboard/products-count`, { params: { d } })
        .then(({ data }) => {
            productsCount.value = data;
            loading.value.productsCount = false;
        });
    axiosClient
        .get(`/dashboard/orders-count`, { params: { d } })
        .then(({ data }) => {
            paidOrders.value = data;
            loading.value.paidOrders = false;
        });
    axiosClient.get(`/dashboard/income`, { params: { d } }).then(({ data }) => {
        totalIncome.value = new Intl.NumberFormat("id-ID", {
            style: "currency",
            currency: "IDR",
            minimumFractionDigits: 2,
        }).format(data);
        loading.value.totalIncome = false;
    });
    axiosClient
    .get(`/dashboard/latest-orders`, { params: { d } })
    .then(({ data: orders }) => {
        latestOrders.value = orders.data;
        loading.value.latestOrders = false;
    });
    axiosClient
        .get(`/dashboard/latest-customers`, { params: {d} })
        .then(({ data: customers }) => {
            latestCustomers.value = customers;
            loading.value.latestCustomers = false;
        });
    axiosClient
        .get(`/dashboard/orders-by-city`, { params: { d } })
        .then(({ data: customer_addresses }) => {
            loading.value.orderByCity = false; // Menandakan proses loading selesai
            const chartData = {
                labels: [],
                datasets: [
                    {
                        backgroundColor: [
                            "#41B883",
                            "#E46651",
                            "#00D8FF",
                            "#DD1B16",
                        ],
                        data: [],
                    },
                ],
            };

            // Mengisi labels dan data menggunakan forEach
            customer_addresses.forEach((c) => {
                chartData.labels.push(c.city_name);
                chartData.datasets[0].data.push(c.count);
            });

            // Menyimpan chartData ke dalam orderByCity
            orderByCity.value = chartData;
        });
}

function onDatePickerChange() {
    updateDashboard();
}

onMounted(() => updateDashboard());
</script>

<style scoped></style>
