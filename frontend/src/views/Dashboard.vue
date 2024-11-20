<template>
    <div>
        <div class="mb-2 flex items-center justify-between">
            <h1 class="text-3xl font-semibold">Dashboard</h1>
            <div class="flex items-center">
                <label class="mr-2">Change Date Period</label>
            </div>
        </div>
        
        <!-- Customer Count Start -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
            <div class="bg-white py-6 px-5 rounded-lg shadow-md flex flex-col items-center justify-center animate-fade-in-down">
                <label for="" class="text-lg font-semibold block mb-2">Active Customer</label>

                <!-- <template>

                </template> -->
            </div>
        </div>
        <!-- Customer Count End -->

        <!-- Products Count Start -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
            <div class="bg-white py-6 px-5 rounded-lg shadow-md flex flex-col items-center justify-center animate-fade-in-down" style="animation-delay: 0.1s;">
                <label for="" class="text-lg font-semibold block mb-2">Active Products</label>

                <!-- <template>

                </template> -->
            </div>
        </div>
        <!-- Products Count End -->

        <!-- Paid Order Start -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
            <div class="bg-white py-6 px-5 rounded-lg shadow-md flex flex-col items-center justify-center animate-fade-in-down" style="animation-delay: 0.2s;">
                <label for="" class="text-lg font-semibold block mb-2">Paid Orders</label>

                <!-- <template>

                </template> -->
            </div>
        </div>         
        <!-- Paid Order End -->

        <!-- Total Income Start -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-4">
            <div class="bg-white py-6 px-5 rounded-lg shadow flex flex-col items-center animate-fade-in-down" style="animation-delay: 0.3s;">
                <label for="" class="text-lg font-semibold block mb-2">Total Income</label>

                <!-- <template>

                </template> -->
            </div>
        </div>  
        <!-- Total Income End -->
    </div>
</template>

<script setup>
import { UserIcon } from "@heroicons/vue/outline";
// import DoughnutChart from "../components/core/Charts/Doughnut.vue";
// import axiosClient from "../axios.js";
import { computed, onMounted, ref } from "vue";
// import Spinner from "../components/core/Spinner.vue";
// import CustomInput from "../components/core/CustomInput.vue";
import { useStore } from "vuex";

const store = useStore();
const dateOptions = computed(() => store.state.dateOptions);
const chosenDate = ref("all");

// const loading = ref({
//     customersCount: true,
//     productsCount: true,
//     paidOrders: true,
//     totalIncome: true,
//     ordersByCountry: true,
//     latestCustomers: true,
//     latestOrders: true,
// });
// // const customersCount = ref(0);
// // const productsCount = ref(0);
// // const paidOrders = ref(0);
// // const totalIncome = ref(0);
// // const ordersByCountry = ref([]);
// // const latestCustomers = ref([]);
// // const latestOrders = ref([]);

// function onDatePickerChange() {
//     updateDashboard();
// }

// onMounted(() => updateDashboard());
</script>

<style scoped></style>
