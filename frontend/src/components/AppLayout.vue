<template>
    <div>
        <!--  -->
        <div v-if="currentUser.id" class="min-h-screen bg-gray-200 flex">
            <!-- <div class="min-h-screen bg-gray-200 flex"> -->
            <!-- <div class="min-h-full bg-gray-200 flex"> -->

            <Sidebar :class="{ '-ml-[200px]': !sidebarOpened }" />

            <div class="flex-1">
                <Navbar @toggle-sidebar="toggleSidebar"></Navbar>

                <main class="p-6">
                    <router-view></router-view>
                </main>
            </div>
        </div>

        <div
            v-else
            class="min-h-full bg-gray-200 flex item-center justify-center"
        >
            <Spinner />
        </div>
        <Toast />
    </div>
</template>

<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import Sidebar from "./Sidebar.vue";
import Navbar from "./Navbar.vue";
import store from "../store";
import Spinner from "./core/Spinner.vue";
import Toast from "./core/Toast.vue";

const { title } = defineProps({
    title: String,
});

const sidebarOpened = ref(true);
const currentUser = computed(() => {
    return store.state.user.data
});

function toggleSidebar() {
    sidebarOpened.value = !sidebarOpened.value;
}

function updateSidebarState() {
    sidebarOpened.value = window.outerWidth > 768;
}

onMounted(async () => {
    store.dispatch("getCurrentUser");
    updateSidebarState();
    window.addEventListener("resize", updateSidebarState);
});

onUnmounted(() => {
    window.removeEventListener("resize", updateSidebarState);
});
</script>
