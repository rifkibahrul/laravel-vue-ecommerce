<template>
    <div class="w-[200px] transition-all bg-indigo-700 text-white py-4 px-2">
        <router-link :to="{name: 'app.dashboard'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30" :class="linkClass('app.dashboard')">
            <span class="mr-2 text-gray-300">
                <HomeIcon class="w-5"/>
            </span>
            <span class="text-lg">
                Dashboard
            </span>
        </router-link>
        <router-link :to="{name: 'app.product'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30" :class="linkClass('app.product')">
            <span class="mr-2 text-gray-300">
                <CollectionIcon class="w-5"/>
            </span>
            <span class="text-lg">
                Products
            </span>
        </router-link>
        <router-link :to="{name: 'app.order'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30" :class="linkClass('app.order')">
            <span class="mr-2 text-gray-300">
                <ShoppingCartIcon class="w-5"/>
            </span>
            <span class="text-lg">
                Orders
            </span>
        </router-link>
        <router-link :to="{name: 'app.user'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30" :class="linkClass('app.user')">
            <span class="mr-2 text-gray-300">
                <UsersIcon class="w-5"/>
            </span>
            <span class="text-lg">
                Users
            </span>
        </router-link>
        <router-link :to="{name: 'app.customer'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30" :class="linkClass('app.customer')">
            <span class="mr-2 text-gray-300">
                <UserGroupIcon class="w-5"/>
            </span>
            <span class="text-lg">
                Customers
            </span>
        </router-link>
        <router-link :to="{name: 'report.orders'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30" :class="linkClass('report.orders')" >
            <span class="mr-2 text-gray-300">
                <ChartBarIcon class="w-5"/>
            </span>
            <span class="text-lg">
                Reports
            </span>
        </router-link> 
    </div>
</template>

<script setup>
import {HomeIcon, UserGroupIcon, UsersIcon, CollectionIcon, ChartBarIcon, ShoppingCartIcon } from '@heroicons/vue/outline'

import { useRoute } from 'vue-router';

const route = useRoute();

const linkClass = (name) => {
    return route.name.startsWith(name) || route.name === name? 'bg-black/30' : ''
}
</script>