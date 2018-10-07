import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        token: '',
        isLoggedIn: null
    },
    mutations: {
        login(state, payload) {
            state.token = 'Bearer '+payload
            axios.defaults.headers.common['Authorization'] = state.token;
            state.isLoggedIn = true
        },
        logout(state) {
            state.token = null
            axios.defaults.headers.common['Authorization'] = ''
            state.isLoggedIn = false
        }
    },
    actions: {

    }
})