<template>
    <div>
        <h1 class="py-12">Login</h1>

        <form @submit.prevent="submit">
            <label>Email:</label>
            <v-text-field
                    type="text"
                    v-model="user.email"
            ></v-text-field>
            <p class="error--text" v-if="errors.email">{{ errors.email }}</p>
            <p class="error--text" v-if="server_errors.email">{{ server_errors.email[0] }}</p>


            <label>Password:</label>
            <v-text-field
                    type="password"
                    v-model="user.password"
            ></v-text-field>
            <p class="error--text" v-if="errors.password">{{ errors.password }}</p>
            <p class="error--text" v-if="server_errors.password">{{ server_errors.password[0] }}</p>

            <v-btn type="submit">Login</v-btn>
        </form>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'
    import { validateLogin } from "./helpers/validator";

    export default {
        name: "Login",

        data() {
            return {
                user: {
                    email: "",
                    password:""
                },
                server_errors: {},
                errors: {}
            }
        },

        methods: {
            ...mapActions(['login']),

            submit() {
                this.server_errors = this.errors = {};

                const { errors, isValid } = validateLogin(this.user);

                if (!isValid) {
                    this.errors =errors;
                } else {
                    this.login(this.user).then().catch(err => this.server_errors = err.response.data.errors);
                }
            }
        }

    }
</script>