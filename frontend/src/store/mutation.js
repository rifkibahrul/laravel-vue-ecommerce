export function setUser(state, user) {
    // console.log("Mutation setUser called with:", user);
    state.user.data = user;
    if (user) {
        sessionStorage.setItem("USER_DATA", JSON.stringify(user));
    } else {
        sessionStorage.removeItem("USER_DATA");
    }
}

export function setToken(state, token) {
    state.user.token = token;
    if (token) {
        sessionStorage.setItem("TOKEN", token);
    } else {
        sessionStorage.removeItem("TOKEN");
        sessionStorage.removeItem("USER_DATA");
    }
}

export function setProducts(state, [loading, data = null]) {
    if (data) {
        state.products = {
            ...state.products,
            data: data.data, // Data produk
            links: data.meta?.links, // Pagination links
            page: data.meta.current_page, // Halaman saat ini
            limit: data.meta.per_page, // Data per halaman
            from: data.meta.from, // Data mulai
            to: data.meta.to, // Data selesai
            total: data.meta.total, // Total data
        };
    }
    state.products.loading = loading; // Atur status loading
}

export function setOrders(state, [loading, data = null]) {
    if (data) {
        state.orders = {
            ...state.orders,
            data: data.data, // Data orders
            links: data.meta?.links, // Pagination
            page: data.meta.current_page, // Halamaan saat ini
            limit: data.meta.per_page, // Data per halaman
            from: data.meta.from, // Data mulai
            to: data.meta.to, // Data selesai
            total: data.meta.total,
        };
    }
    state.orders.loading = loading;
}

export function setUsers(state, [loading, data = null]) {
    if (data) {
        state.users = {
            ...state.users,
            data: data.data, // Data users
            links: data.meta?.links, // Pagination
            page: data.meta.current_page, // Halamaan saat ini
            limit: data.meta.per_page, // Data per halaman
            from: data.meta.from, // Data mulai
            to: data.meta.to, // Data selesai
            total: data.meta.total,
        };
    }
    state.products.loading = loading;
}

export function showToast(state, message) {
    state.toast.show = true;
    state.toast.message = message;
}

export function hideToast(state) {
    state.toast.show = false;
    state.toast.message = "";
}
