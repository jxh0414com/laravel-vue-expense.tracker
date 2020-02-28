<template>
    <div>
        <AddTransactionModal></AddTransactionModal>
        <TransactionTable></TransactionTable>
        <v-btn @click.prevent="logout" class="logout">Logout</v-btn>

        <p v-if="total" class="overline text-center mt-6 blue--text lighten-2">Total Expense on {{ transaction.on }} : {{ total }}</p>
        <v-form @submit.prevent="submit">
            <v-col cols="12">
                <v-select
                        v-model="transaction.on"
                        :items="on"
                        label="Total Expense on?/income"
                        required
                ></v-select>
                <p class="error--text" v-if="error">{{ error }}</p>
                <p class="error--text" v-if="server_error">{{ server_error }}</p>
            </v-col>

            <v-btn type="submit">Get</v-btn>
        </v-form>
    </div>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    import AddTransactionModal from './layout/AddTransactionModal'
    import TransactionTable from './layout/TransactionTable'

    export default {
        name: "Dashboard",

        components: { AddTransactionModal, TransactionTable },

        computed: {
            ...mapGetters({ total: 'getTotal' })
        },

        methods: {
            ...mapActions(['logout', 'getTransactions', 'getTotal']),
            submit() {
                this.error = this.server_error = "";

                if (!this.transaction.on) {
                    this.error = "GET TOTAL 'ON' is required";
                } else {
                    this.getTotal(this.transaction).then().catch(err => this.server_error = err.response.data.errors.on[0]);
                }
            }
        },

        created() {
          this.getTransactions();
        },

        data() {
          return {
              on: [
                  { text: "Housing", value: "Housing" },
                  { text: "Food", value: "Food" },
                  { text: "Groceries", value: "Groceries" },
                  { text: "Vehicle", value: "Vehicle" },
                  { text: "Income", value: "Income" },
                  { text: "Entertainment", value: "Entertainment" },
                  { text: "Shopping", value: "Shopping" },
                  { text: "Others", value: "Others" },
              ],
              transaction: {
                  on: ""
              },
              error: "",
              server_error: ""
          }
        }
    }
</script>

<style scoped>
    .logout {
        position: fixed;
        right: 15px;
        top: 75px
    }
</style>