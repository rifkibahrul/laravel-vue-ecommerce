<template>
    <div v-if="order">
        <!-- Orders Details Start -->
        <div>
            <h2
                class="flex justify-between items-center text-xl font-semibold pb-2 border-b border-gray-300"
            >
                Order Details
                <OrderStatus :order="order" />
            </h2>
            <table>
                <tbody>
                    <tr>
                        <td class="font-bold py-1 px-2">Order #</td>
                        <td>{{ order.id }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Order Date</td>
                        <td>{{ order.created_at }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Order Status</td>
                        <td>
                            <select
                                v-model="order.status"
                                @change="onStatusChange"
                            >
                                <option
                                    v-for="status of orderStatus"
                                    :value="status"
                                    :key="status"
                                >
                                    {{ status }}
                                </option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">SubTotal</td>
                        <td>{{ formatRupiah(order.total_price) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Orders Detail End -->

        <!-- Customer Details Start -->
        <div>
            <h2
                class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300"
            >
                Customer Details
            </h2>
            <table>
                <tbody>
                    <tr>
                        <td class="font-bold py-1 px-2">Full Name</td>
                        <td>
                            {{ order.customer.first_name }}
                            {{ order.customer.last_name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Email</td>
                        <td>{{ order.customer.email }}</td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Phone</td>
                        <td>{{ order.customer.phone }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Customer Details End -->

        <!-- Address Details Start -->
        <div>
            <h2
                class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300"
            >
                Alamat Pengiriman
            </h2>
            <table>
                <tbody>
                    <tr>
                        <td class="font-bold py-1 px-2">Alamat</td>
                        <td>
                            {{ order.customer.customerAddress.address }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Kab / Kota</td>
                        <td>
                            {{ order.customer.customerAddress.city_name }}
                        </td>
                    </tr>
                    <tr>
                        <td class="font-bold py-1 px-2">Provinsi</td>
                        <td>
                            {{ order.customer.customerAddress.province_name }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- Address Details End -->

        <!-- Order Item Start -->
        <div>
            <h2
                class="text-xl font-semibold mt-6 pb-2 border-b border-gray-300"
            >
                Item
            </h2>
            <div v-for="item of order.items" v-bind:key="item.id">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <a
                        href="#"
                        class="w-36 h-32 flex items-center justify-center overflow-hidden"
                    >
                        <img :src="item.product.image" alt="/" />
                    </a>
                    <div class="flex flex-col justify-between flex-1">
                        <div class="flex justify-between mb-3">
                            <h3>
                                {{ item.product.title }}
                            </h3>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center">
                                Qty: {{ item.quantity }}
                            </div>
                            <span class="text-lg font-semibold">{{
                                formatRupiah(item.unit_price)
                            }}</span>
                        </div>
                    </div>
                </div>
                <hr class="my-3"/>
            </div>
        </div>
        <!-- Order Item End -->
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import store from "../../store";
import { useRoute } from "vue-router";
import axiosClient from "../../axios";
import OrderStatus from "./OrderStatus.vue";

const route = useRoute();

const order = ref(null);
const orderStatus = ref([]);

onMounted(() => {
    store.dispatch("getOrder", route.params.id).then(({ data }) => {
        order.value = data;
    });

    axiosClient
        .get(`/orders/status`)
        .then(({ data }) => orderStatus.value = data);
});

function onStatusChange() {
    axiosClient.post(`/orders/change-status/${order.value.id}/${order.value.status}`)
        .then(({data}) => {
            store.commit('showToast', `Order status was successfully changed into "${order.value.status}"`)
            console.log(store.state.toast)
        })
}

function formatRupiah(value) {
    if (!value) return "Rp0";
    return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 2,
    }).format(value);
}
</script>
