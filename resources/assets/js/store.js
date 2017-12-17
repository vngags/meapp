import VueX from 'vuex'
import Vue from 'vue'

Vue.use(VueX)

export const store = new VueX.Store({
    state: {
        auth_user_data: [],
        profile_user_data: []
    },
    getters: {
        get_auth_user_data(state) {
            return state.auth_user_data
        },
        get_profile_user_data(state) {
            return state.profile_user_data
        }
    },
    mutations: {
        add_auth_user_data(state, user) {
            state.auth_user_data = user
        },
        add_profile_user_data(state, user) {
            state.profile_user_data = user
        }
    }
})