import VueX from 'vuex'
import Vue from 'vue'

Vue.use(VueX)

export const store = new VueX.Store({
    state: {
        auth_user_data: [],
        profile_user_data: [],
        notifications: []
    },
    getters: {
        get_auth_user_data(state) {
            return state.auth_user_data
        },
        get_profile_user_data(state) {
            return state.profile_user_data
        },
        get_notifications(state) {
            return state.notifications
        }
    },
    mutations: {
        add_auth_user_data(state, user) {
            state.auth_user_data = user
        },
        add_profile_user_data(state, user) {
            state.profile_user_data = user
        },
        add_new_following(state, user) {     
            state.profile_user_data.followers.push({
                slug: user.slug,
                avatar: user.avatar
            })
        },
        remove_following(state, slug) {
            var follower = state.profile_user_data.followers.find((u) => {
                return u.slug === slug
            })
            var index = state.profile_user_data.followers.indexOf(follower)
            state.profile_user_data.followers.splice(index, 1)
        },
        add_new_notification(state, not) {
            state.auth_user_data.notifications.unshift(not)
            document.getElementById("bell_audio").play();
            $(".notification").removeClass("notify");
            setTimeout(function() {
                $(".notification").addClass("notify");
            }, 10);
        },
        add_unread_notification(state, not) {
            state.notifications.push(not)
        }
    }
})