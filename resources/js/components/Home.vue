<template>
    <div>
        <template v-if="!isAuthenticated">
            <v-tabs v-model="tab" centered>
                <v-tab key="Login">
                    Login
                </v-tab>

                <v-tab key="Register">
                    Register
                </v-tab>
            </v-tabs>

            <v-tabs-items v-model="tab">
                <v-tab-item key="Login">
                    <Login></Login>
                </v-tab-item>

                <v-tab-item key="Register">
                    <Register></Register>
                </v-tab-item>
            </v-tabs-items>
        </template>

        <template v-else>
            <Dashboard></Dashboard>
        </template>
    </div>
</template>

<script>
    import Login from './Login';
    import Register from './Register'
    import Dashboard from './Dashboard'

    export default {
        name: "Home",

        components: { Login, Register, Dashboard },

        data() {
            return {
                tab: null,
                isAuthenticated: !!localStorage.getItem('token')
            }
        },

    }
</script>