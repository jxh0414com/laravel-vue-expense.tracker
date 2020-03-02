<template>
    <div>
        <v-app-bar color="indigo lighten-3" dark>
            <v-app-bar-nav-icon @click="drawer = true"></v-app-bar-nav-icon>

            <v-toolbar-title><router-link class="route-link" :to="{ name: 'home' }">Expense Tracker</router-link></v-toolbar-title>
            <v-spacer></v-spacer>
            <a class="route-link" href="https://github.com/jxh0414com/laravel-vue-expense.tracker">Github</a>
        </v-app-bar>

        <v-navigation-drawer v-model="drawer" absolute temporary style="width: 350px">
            <v-card flat v-if="isAuthenticated">
                <v-card-text>
                    <h1> {{ user.name }}</h1>
                    <h3> {{ user.email }}</h3>
                    <p>Funds: </p>
                    <div class="red--text" v-if="user.funds < 0">
                        <v-icon class="red--text">mdi-currency-usd</v-icon>{{ user.funds }}
                        <p class="mt-8 red--text overline">You're spending more than your earning!</p>
                    </div>

                    <div class="green--text" v-else>
                        <v-icon class="green--text">mdi-currency-usd</v-icon>{{ user.funds }}
                        <p class="mt-8 green--text overline">Keep up the great work!</p>
                    </div>
                </v-card-text>
            </v-card>

            <v-card v-else flat>
                <v-card-text>
                    Login to see
                </v-card-text>
            </v-card>
        </v-navigation-drawer>
    </div>
</template>

<script>
    import { mapGetters } from 'vuex'

    export default {
        name: "Navbar",

        data() {
            return {
                drawer: false,
                isAuthenticated: !!localStorage.getItem('token')
            }
        },
        computed: {
            ...mapGetters({ user: 'getUser'})
        }
    }
</script>

<style>
    .route-link {
        color: white !important;
        text-decoration: none;
    }
</style>