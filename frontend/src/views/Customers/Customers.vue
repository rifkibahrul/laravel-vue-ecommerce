<template>
    <div>
        <div class="flex items-center justify-between mb-3">
            <h1 class="text-3xl font-semibold">Customers</h1>
        </div>
        <CustomersTable @clickEdit="editCustomer" />
    </div>
</template>

<script setup>
import { computed, onMounted, ref } from "vue";
import store from "../../store";
import CustomersTable from "./CustomersTable.vue";

const DEFAULT_CUSTOMER = {};

const Customers = computed(() => store.state.Customers);

const customerModel = ref({ ...DEFAULT_CUSTOMER });

const showCustomerModal = ref(false);

function showAddNewModal() {
    showCustomerModal.value = true;
}

function editCustomer(c) {
    store.dispatch
}

function onModalClose() {
    customerModel.value = {...DEFAULT_CUSTOMER};
}
</script>
