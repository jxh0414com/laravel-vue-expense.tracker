<template>
    <div>
        <h1 class="py-12">Register</h1>

        <form @submit.prevent="submit">
            <label>Name:</label>
            <v-text-field type="text" v-model="user.name"></v-text-field>
            <p class="error--text" v-if="errors.name">{{ errors.name }}</p>
            <p class="error--text" v-if="server_errors.name">{{ server_errors.name[0] }}</p>

            <label>Email:</label>
            <v-text-field type="text" v-model="user.email"></v-text-field>
            <p class="error--text" v-if="errors.email">{{ errors.email }}</p>
            <p class="error--text" v-if="server_errors.email">{{ server_errors.email[0] }}</p>

            <label>Password:</label>
            <v-text-field type="password" v-model="user.password"></v-text-field>
            <p class="error--text" v-if="errors.password">{{ errors.password }}</p>
            <p class="error--text" v-if="server_errors.password">{{ server_errors.password[0] }}</p>

            <label>Confirm Password:</label>
            <v-text-field type="password" v-model="user.password_confirmation"></v-text-field>
            <p class="error--text" v-if="errors.password_confirmation">{{ errors.password_confirmation }}</p>
            <p class="error--text" v-if="server_errors.password_confirmation">{{ server_errors.password_confirmation[0] }}</p>

            <v-btn type="submit">Register</v-btn>
        </form>
    </div>
</template>

<script>
    import { mapActions } from 'vuex'
    import { validateRegister } from "./helpers/validator";

    export default {
        name: "Register",

        data() {
            return {
                user: {
                    name: "",
                    email: "",
                    password:"",
                    password_confirmation: ""
                },
                server_errors: {},
                errors: {}
            }
        },

        methods: {
            ...mapActions(['register']),

            submit() {
                this.server_errors = this.errors = {};

                const { errors, isValid } = validateRegister(this.user);

                if (!isValid) {
                    this.errors =errors;
                } else {
                    this.register(this.user).then().catch(err => this.server_errors = err.response.data.errors);
                }
            }
        }

    }
</script>