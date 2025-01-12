import axiosClient from "../axios";

/* MENDAPATKAN USERS YANG SAAT INI SEDANG LOGIN */
export function getCurrentUser({ commit }, data) {
    return axiosClient.get("/user", data).then(({ data }) => {
        // console.log("data user: ", data);
        // console.log("data user: ", data.data);
        commit("setUser", data.data);
        return data.data;
    });
}

export function login({ commit }, data) {
    return axiosClient
        .post("/login", data)
        .then((response) => {
            // console.log('Response data:', response.data);
            const userData = response.data.user;
            // console.log('User data:', userData);
            if (userData && userData.id) {
                commit("setUser", userData);
                commit("setToken", response.data.token);
                return response.data;
            } else {
                console.error("Invalid response data");
                throw new Error("Invalid response data");
            }
        })
        .catch((error) => {
            console.error("Error logging in:", error);
            throw error;
        });
}

export function logout({ commit }) {
    return axiosClient.post("/logout").then((response) => {
        commit("setToken", null);
        return response;
    });
}

/* MENAMPILKAN SEMUA PRODUK */
export function getProducts(
    { commit, state },
    { url = null, search = "", per_page, sort_field, sort_direction } = {}
) {
    commit("setProducts", [true]); // Tampilkan loading
    url = url || "/products"; // Endpoint default
    const params = {
        per_page: state.products.limit,
    };

    return axiosClient
        .get(url, {
            params: {
                ...params,
                search,
                per_page,
                sort_field,
                sort_direction,
            },
        })
        .then((response) => {
            commit("setProducts", [false, response.data]); // Simpan data produk
        })
        .catch(() => {
            commit("setProducts", [false]); // Sembunyikan loading jika gagal
        });
}

/* MENAMBAHKAN PRODUK */
export function createProduct({ commit }, product) {
    if (product.image instanceof File) {
        const form = new FormData();
        form.append("title", product.title);
        form.append("image", product.image);
        form.append("description", product.description || "");
        form.append("price", product.price);
        form.append("published", product.published ? 1 : 0);
        product = form;
    }
    return axiosClient.post("/products", product);
}

/* DATA PER PRODUK */
export function getProduct({ commit }, id) {
    return axiosClient.get(`/products/${id}`);
}

/* MEMPERBARUI DATA PRODUK */
export function updateProduct({ commit }, product) {
    const id = product.id;
    if (product.image instanceof File) {
        const form = new FormData();
        form.append("title", product.title);
        form.append("image", product.image);
        form.append("description", product.description || "");
        form.append("price", product.price);
        form.append("published", product.published ? 1 : 0);
        form.append("_method", "PUT");
        product = form;
    } else {
        product._method = "PUT";
    }

    return axiosClient.post(`/products/${id}`, product);
}

/* MENGHAPUS DATA PRODUK */
export function deleteProduct({ commit }, id) {
    return axiosClient.delete(`/products/${id}`);
}

/* MENAMPILKAN SEMUA DATA ORDER */
export function getOrders(
    { commit, state },
    { url = null, search = "", per_page, sort_field, sort_direction } = {}
) {
    commit("setOrders", [true]);
    url = url || "/orders";
    const params = {
        per_page: state.orders.limit,
    };

    return axiosClient
        .get(url, {
            params: {
                ...params,
                search,
                per_page,
                sort_field,
                sort_direction,
            },
        })
        .then((response) => {
            commit("setOrders", [false, response.data]);
        })
        .catch(() => {
            commit("setOrders", [false]);
        });
}

/* MENAMPILKAN DATA PER ORDERAN */
export function getOrder({ commit }, id) {
    return axiosClient.get(`/orders/${id}`);
}

/* MENDAPATKAN DATA SEMUA USER */
export function getUsers(
    { commit, state },
    { url = null, search = "", per_page, sort_field, sort_direction } = {}
) {
    commit("setUsers", [true]);
    url = url || "/users";
    const params = {
        per_page: state.users.limit,
    };

    return axiosClient
        .get(url, {
            params: {
                ...params,
                search,
                per_page,
                sort_field,
                sort_direction,
            },
        })
        .then((response) => {
            commit("setUsers", [false, response.data]);
        })
        .then(() => {
            commit("setUsers", [false]);
        });
}

/* MENDAPATKAN DATA PER USER */
export function getUser({ commit }, id) {
    return axiosClient.get(`/users/${id}`);
}

export function createUser({ commit }, user) {
    return axiosClient.post("/users", user);
}

export function updateUser({ commit }, user) {
    return axiosClient.put(`/users/${user.id}`, user);
}

export function deleteUser({ commit }, id) {
    return axiosClient.delete(`/users/${id}`);
}

/* MENDAPATKAN DATA SELURUH CUSTOMER */
export function getCustomers(
    { commit, state },
    { url = null, search = "", per_page, sort_field, sort_direction } = {}
) {
    commit("setCustomers", [true]);
    url = url || "/customers";
    const params = {
        per_page: state.customers.limit,
    };
    return axiosClient
        .get(url, {
            params: {
                ...params,
                search,
                per_page,
                sort_field,
                sort_direction,
            },
        })
        .then((response) => {
            commit("setCustomers", [false, response.data]);
        })
        .then(() => {
            commit("setCustomers", [false]);
        });
}

/* MENDAPATKAN DATA PER CUSTOMER */
export function getCustomer({ commit }, id) {
    return axiosClient
        .get(`/customers/${id}`)
        .then((response) => {
            if (response.status === 200) {
                // console.log("Data dari API (getCustomer):", response.data);
                return response;
            } else {
                throw new Error("Gagal mengambil data customer");
            }
        })
        .catch((error) => {
            console.error("Error fetching customer:", error);
        });
}

/* MENGHAPUS DATA CUSTOMER */
export function deleteCustomer({ commit }, customer) {
    return axiosClient.delete(`/customers/${customer.id}`);
}

/* MEMPERBARUI DATA CUSTOMER */
export function updateCustomer({ commit }, customer) {
    return axiosClient.put(`/customers/${customer.id}`, customer);
}

/* MENAMBAH DATA CUSTOMER */
export function createCustomer({ commit }, customer) {
    return axiosClient.post('/customers', customer);
}
