import { createStore } from 'vuex';
import * as mutations from './mutation';
import * as actions from './actions';
import state from './state';

const store = createStore ({
    state,
    getters: {},
    actions,
    mutations,
})

export default store