import Vue from 'vue'
import { mapGetters } from 'vuex'

const User = {
    install (Vue, Options) {
        Vue.mixin({
            computed: {
                ...mapGetters({
                    user: 'auth/user',
                    loggedIn: 'auth/loggedIn',
                    authenticated: 'auth/authenticated',
                    isUserActive: 'users/isUserActive',
                })
            }
        })
    }
}

Vue.use(User);