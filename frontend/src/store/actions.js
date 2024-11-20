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