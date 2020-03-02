<template>
    <v-row justify="center">
        <v-dialog v-model="dialog" persistent max-width="600px">
            <template v-slot:activator="{ on }">
                <v-btn color="primary" dark v-on="on">Add Transaction</v-btn>
            </template>
            <v-form @submit.prevent="submit">
            <v-card>
                <v-card-title>
                    <span class="headline">Add transaction</span>
                </v-card-title>
                <v-card-text>
                    <v-container>
                        <v-row>
                            <v-col cols="12">
                                <v-select
                                        v-model="transaction.on"
                                        :items="onChoice"
                                        label="On?"
                                        required
                                ></v-select>
                                <p class="error--text" v-if="errors.on">{{ errors.on }}</p>
                                <p class="error--text" v-if="server_errors.on">{{ server_errors.on[0] }}</p>
                            </v-col>

                            <v-col cols="12">
                                <v-textarea
                                        solo
                                        v-model="transaction.description"
                                        label="Description"
                                        clearable
                                        clear-icon
                                        auto-grow
                                        items-per-page=20
                                ></v-textarea>
                            </v-col>

                            <v-col cols="12">
                                <v-radio-group v-model="transaction.type">
                                    <v-radio label="Expense" value="expense"></v-radio>
                                    <v-radio label="Income" value="income"></v-radio>
                                </v-radio-group>
                                <p class="error--text" v-if="errors.type">{{ errors.type }}</p>
                                <p class="error--text" v-if="server_errors.type">{{ server_errors.type[0] }}</p>
                            </v-col>

                            <v-col cols="12">
                                <v-text-field label="*Amount" v-model="transaction.amount" required prefix="$"></v-text-field>
                                <p class="error--text" v-if="errors.amount">{{ errors.amount }}</p>
                                <p class="error--text" v-if="server_errors.amount">{{ server_errors.amount[0] }}</p>
                            </v-col>

                            <v-menu
                                    v-model="menu"
                                    :close-on-content-click="false"
                                    :nudge-right="40"
                                    transition="scale-transition"
                                    offset-y
                                    min-width="290px"
                            >
                                <template v-slot:activator="{ on }">
                                    <v-text-field
                                            v-model="transaction.date"
                                            label="Date"
                                            prepend-icon="mdi-events"
                                            readonly
                                            v-on="on"
                                    ></v-text-field>
                                </template>
                                <v-date-picker v-model="transaction.date" @input="menu = false"></v-date-picker>
                            </v-menu>

                            <v-col cols="12">
                                <v-text-field label="Location/Place*" type="text" v-model="transaction.location" required></v-text-field>
                                <p class="error--text" v-if="errors.location">{{ errors.location }}</p>
                                <p class="error--text" v-if="server_errors.location">{{ server_errors.location[0] }}</p>
                            </v-col>
                        </v-row>
                    </v-container>
                    <small>*indicates required field</small>
                </v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="blue darken-1" text @click="dialog = false">Close</v-btn>
                    <v-btn color="blue darken-1" text type="submit">Add</v-btn>
                </v-card-actions>
            </v-card>
            </v-form>
        </v-dialog>
    </v-row>
</template>

<script>
    import { mapActions } from 'vuex'
    import { validateTransaction } from "../helpers/validator";

    export default {
        name: 'AddTransactionModal',

        data() {
            return {
                dialog: false,
                transaction: {
                    on: "",
                    description: "",
                    type: "",
                    amount: null,
                    date: new Date().toISOString().substr(0, 10),
                    location: ""
                },
                onChoice: [
                    { text: "Housing", value: "Housing" },
                    { text: "Food", value: "Food" },
                    { text: "Groceries", value: "Groceries" },
                    { text: "Vehicle", value: "Vehicle" },
                    { text: "Income", value: "Income" },
                    { text: "Entertainment", value: "Entertainment" },
                    { text: "Shopping", value: "Shopping" },
                    { text: "Others", value: "Others" },
                ],
                menu: false,
                server_errors: {},
                errors: {}
            }
        },
        methods: {
            ...mapActions(['addTransaction']),
            submit() {
                this.server_errors = this.errors = {};

                const { errors, isValid } = validateTransaction(this.transaction);

                if (!isValid) {
                    this.errors = errors;
                } else {
                    this.addTransaction(this.transaction).then(() => {
                        this.transaction.on = this.transaction.location = this.transaction.description = this.transaction.type = ""
                        this.transaction.amount = null;
                        this.transaction.date = new Date().toISOString().substr(0, 10)
                        this.dialog = false;
                    }).catch(err => {
                        this.server_errors = err.response.data.errors
                    })
                }
            }
        }
    }
</script>