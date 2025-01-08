<template>
    <div>
        <div class="flex items-center justify-between mb-3">
            <h1 class="text-3xl font-semibold">Users</h1>
            <button
                type="button"
                class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                @click="showAddNewModal()"
            >
                Add new user
            </button>
        </div>
        <UsersTable @clickEdit="editUser"/>
        <UsersModal v-model="showUserModal" :user="userModel" @close="onModalClose" />
    </div>
</template>

<script setup>
import UsersTable from "./UsersTable.vue";
import UsersModal from "./UsersModal.vue";
import { computed, ref } from "vue";

const DEFAULT_USER = {
    id: "",
    email: "",
};

const users = computed(() => store.state.users);

const userModel = ref({ ...DEFAULT_USER });
const showUserModal = ref(false);

function showAddNewModal() {
    showUserModal.value = true;
}

function editUser(u) {
    userModel.value = u;
    showAddNewModal();
}

function onModalClose() {
    userModel.value = {...DEFAULT_USER}
}
</script>
