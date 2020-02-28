import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter);

const routes = [
    {
        path: "/", name: "home", component: require('./components/Home').default
    },
    {
        path: "*", name: "404", component: require('./components/404').default
    },
]

export default new VueRouter({ mode: "history", routes: routes })