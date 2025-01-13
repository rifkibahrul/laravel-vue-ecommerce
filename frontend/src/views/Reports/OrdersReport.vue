<template>
    <BarChart v-if="!loading" :data="chartData" :height="240" />
</template>

<script setup>
import axiosClient from "../../axios";
import { ref, watch } from "vue";
import BarChart from "../../components/core/charts/Bar.vue";
import { useRoute } from "vue-router";

const route = useRoute();
const loading = ref(true);
const chartData = ref([]);

watch(
    route,
    (rt) => {
        getData();
    },
    { immediate: true }
);

function getData() {
    loading.value = true;
    axiosClient
        .get("/report/orders", { params: { d: route.params.date } })
        .then(({ data }) => {
            chartData.value = data;
        })
        .finally(() => {
            loading.value = false;
        });
}
</script>
