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
        console.log('Response data:', response.data);
        const userData = response.data.user;
        console.log('User data:', userData);
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

