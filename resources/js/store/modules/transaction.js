import axios from 'axios'

export default {
    state: {
        transactions: [],
        token: localStorage.getItem('token'),
        total: null
    },
    actions: {
        addTransaction: ({ commit, state }, data) => {
            return axios.post('/api/transactions', data, { headers: { 'Authorization': 'Bearer ' + state.token }}).then(res => {
                commit('addTransaction', res.data.transaction)
                commit('setUser', res.data.user)
            })
        },
        getTransactions: ({ commit, state }) => {
            axios.get('/api/transactions', { headers: { 'Authorization': 'Bearer ' + state.token }}).then(res => {
                commit('setTransactions', res.data.transactions)
            })
        },
        deleteTransaction: ({ commit, state }, id) => {
            axios.post('/api/transactions/delete', id, { headers: { 'Authorization': 'Bearer ' + state.token }}).then((res) => {
                commit('setTransactions', res.data.transactions);
                commit('setUser', res.data.user);
            })
        },
        getTotal: ({ commit, state }, data) => {
            return axios.post('/api/transactions/getTotal', data, { headers: { 'Authorization': 'Bearer ' + state.token }}).then(res => {
                commit('setTotal', res.data.total);
            })
        }
    },
    getters: {
        getTransactions: (state) => { return state.transactions },
        getTotal: (state) => { return state.total }
    },
    mutations: {
        addTransaction: (state, transaction) => {
            state.transactions = [transaction, ...state.transactions]
        },
        setTransactions: (state, transactions) => {
            state.transactions = transactions
        },
        setTotal: (state, total) => {
            state.total = total;
        }
    },
}