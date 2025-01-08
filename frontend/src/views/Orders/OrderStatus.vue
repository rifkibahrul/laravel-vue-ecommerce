<template>
    <span
        class="text-white py-1 px-2 rounded"
        :class="{
            'bg-emerald-500': order.status.toLowerCase() === 'settlement',
            'bg-orange-400': order.status.toLowerCase() === 'pending',
            'bg-red-500': order.status.toLowerCase() === 'expire',
        }"
        >{{ formattedStatus }}</span
    >
</template>

<script setup>
import { computed } from 'vue';
const {order} = defineProps({
    order: Object
});

const formattedStatus = computed(() => {
    return order.status.charAt(0).toUpperCase() + order.status.slice(1).toLowerCase();
});
</script>
