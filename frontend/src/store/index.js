import { createStore } from 'vuex';
import * as mutations from './mutation';
import * as actions from './actions';

const store = createStore ({
    state: {
        user: {
            token: sessionStorage.getItem('TOKEN'),
            data: {}
        }
    },
    getters: {},
    actions,
    mutations,
})

export default store