import {createRouter, createWebHistory} from "vue-router";

import Dashboard from "../views/Dashboard.vue";
import Login from "../views/Login.vue";
import RequestPassword from "../views/RequestPassword.vue";
import ResetPassword from "../views/ResetPassword.vue";
import GuestLayout from "../components/GuestLayout.vue";
import AppLayout from "../components/AppLayout.vue";
import store from "../store";
import NotFound from "../views/NotFound.vue"

const routes = [
    {
        path: '/app',
        name: 'app',
        component: AppLayout,
        meta: {
            requiresAuth: true  // perlu autentikasi atau login
        },
        children: [
            {
                path: '/dashboard',
                name: 'app.dashboard',
                component: Dashboard
            },
            // {
            //     path: '/products',
            //     name: 'app.products',
            //     component: Products
            // },
        ]
    },
    {
        path: '/login',
        name: 'login',
        component: Login,
        meta: {
            requiresGuest: true
        }
    },
    {
        path: '/request-password',
        name: 'request-password',
        component: RequestPassword,
        meta: {
            requiresGuest: true
        }
    },
    {
        path: '/reset-password/:token',
        name: 'reset-password',
        component: ResetPassword,
        meta: {
            requiresGuest: true
        }
    },
    // {
    //     path: '/guest',
    //     name: 'guest',
    //     component: GuestLayout
    // },
    {
        path: '/:pathMatch(.*)',
        name: 'notFound',
        component: NotFound
    }
];

const router = createRouter({
    history: createWebHistory(), 
    routes
});

router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth && !store.state.user.token) {
        next({ name: 'login' });
    } else if (to.meta.requiresGuest && store.state.user.token) {
        next({ name: 'app.dashboard' });
    } else {
        next();
    }
})

export default router;