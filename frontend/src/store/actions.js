import axiosClient from "../axios";

export function getUser({commit}, data){
    return axiosClient.get('/user', data)
        .then(({data}) => {
            commit('setUser', data);
            return data;
        })
}


export function login({ commit }, data) {
    return axiosClient.post('/login', data)
     .then(response => {
        // console.log('Response data:', response.data);
        const userData = response.data.user;
        // console.log('User data:', userData);
        if (userData && userData.id) {
          commit('setUser', userData);
          commit('setToken', response.data.token);
          return response.data;
        } else {
          console.error('Invalid response data');
          throw new Error('Invalid response data');
        }
      })
     .catch(error => {
        console.error('Error logging in:', error);
        throw error;
      });
  }
  


export function logout({commit}) {
    return axiosClient.post('/logout')
        .then((response) => {
            commit('setToken', null);
            return response;
        })
}

/* MENAMPILKAN SEMUA PRODUK */
export function getProducts({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
    commit('setProducts', [true])   // Tampilkan loading
    url = url || '/products'    // Endpoint default
    const params = {
      per_page: state.products.limit
    }

    return axiosClient.get(url, {
      params: {
        ...params,
        search,
        per_page,
        sort_field,
        sort_direction
      }
    })
        .then((response) => {
          commit('setProducts', [false, response.data])   // Simpan data produk
        })
        .catch(() => {
          commit('setProducts', [false])    // Sembunyikan loading jika gagal
        })
}

/* MENAMBAHKAN PRODUK */
export function createProduct({commit}, product) {
  if (product.image instanceof File) {
    const form = new FormData();
    form.append('title', product.title);
    form.append('image', product.image);
    form.append('description', product.description || '');
    form.append('price', product.price);
    form.append('published', product.published ? 1 : 0);
    product = form;
  }
  return axiosClient.post('/products', product);
}

/* DATA PER PRODUK */
export function getProduct({commit}, id) {
  return axiosClient.get(`/products/${id}`);
}

/* MEMPERBARUI DATA PRODUK */

export function updateProduct({commit}, product) {
  const id = product.id;
  if (product.image instanceof File) {
    const form = new FormData();
    form.append('title', product.title);
    form.append('image', product.image);
    form.append('description', product.description || '');
    form.append('price', product.price);
    form.append('published', product.published ? 1 : 0);
    form.append('_method', 'PUT');
    product = form;
  } else {
    product._method = 'PUT';
  }

  return axiosClient.post(`/products/${id}`, product);
} 