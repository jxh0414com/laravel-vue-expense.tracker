import axios from 'axios'
import router from '../../router'

export default {
    state: {
        token: "",
        user: {}
    },
    actions: {
        register: ({ commit}, data) => {
            return axios.post('/api/user/register', data).then(res => {
                localStorage.setItem('token', res.data.token)
                commit('setToken', res.data.token);
                commit('setUser', res.data.user)
                router.go({ name: 'home' })
            })
        },
        login: ({ commit }, data) => {
            return axios.post('/api/auth/login', data).then(res => {
                localStorage.setItem('token', res.data.token)
                commit('setToken');
                router.go({ name: 'home' })
            })
        },
        loadUser: ({ commit }, token) => {
            if (!token) {
                return;
            } else {
                axios.get('/api/auth/loadUser', { headers: { 'Authorization': 'Bearer ' + token }}).then(res => {
                    commit('setToken', token)
                    commit('setUser', res.data.user);
                }).catch(() => {
                    commit('removeAuth')
                    router.go({ name: 'home' })
                })
            }
        },
        logout: ({ state, commit }) => {
            axios.get('/api/auth/logout', { headers: { 'Authorization': 'Bearer ' + state.token }}).then(() => {
                commit('removeAuth');
                router.go({ name: 'home' })
            })
        }
    },
    getters: {
        getUser: state => { return state.user }
    },
    mutations: {
        setToken: (state, token) => {
            state.token = token
        },
        setUser: (state, user) => {
            state.user = user
        },
        removeAuth: (state) => {
            state.user = {};
            state.token = "";
            localStorage.removeItem('token')
        }
    },
}