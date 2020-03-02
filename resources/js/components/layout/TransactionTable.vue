<template>
    <v-card class="mt-12">
        <v-card-title>
            Transaction
            <v-spacer></v-spacer>
            <v-text-field
                    v-model="search"
                    append-icon="mdi-magnify"
                    label="Search"
                    single-line
                    hide-details
            ></v-text-field>
        </v-card-title>
        <v-data-table
                :headers="headers"
                :items="getTransactions"
                :search="search"
                show-group-by
                single-select
                show-select
                v-model="selected"
        >
            <template v-slot:item.amount="{item}">
                <span v-if="item.type === 'income' " class="green--text"><v-icon class="green--text">mdi-currency-usd</v-icon>+ {{item.amount}}</span>
                <span v-else class="red--text"><v-icon class="red--text">mdi-currency-usd</v-icon>- {{ item.amount }}</span>
            </template>

            <template v-slot:top>
                    <v-btn class="ml-4 error" v-if="selected.length > 0" @click.prevent="dialog = true">Delete</v-btn>
                    <v-dialog v-model="dialog" max-width="290">
                        <v-card>
                            <v-card-title class="headline">Confirm your delete</v-card-title>
                            <v-divider></v-divider>

                            <v-card-text class="mt-4">
                                Are you sure you want to delete this transaction? There is no going back.
                            </v-card-text>

                            <v-card-actions>
                                <v-spacer></v-spacer>

                                <v-btn color="red darken-1" text @click.prevent="dialog = false">Cancel</v-btn>

                                <v-btn color="green darken-1" text @click.prevent="submit">Confirmed</v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>
            </template>

        </v-data-table>
    </v-card>
</template>

<script>
    import { mapGetters, mapActions } from 'vuex'
    export default {
        name: "TransactionTable",
        computed: {
            ...mapGetters(['getTransactions'])
        },
        data() {
            return {
                search: '',
                headers: [
                    { text: 'On', value: 'on' },
                    { text: 'Description', sortable:false, value: 'description' },
                    { text: 'Amount', value: 'amount' },
                    { text: 'Date', value: 'date' },
                    { text: 'Location', value: 'location' },
                ],
                selected: [],
                dialog: false,
            }
        },
        methods: {
            ...mapActions(['deleteTransaction']),
            submit() {
                this.deleteTransaction({ id: this.selected[0].id}).then(() => {
                    this.selected = [];
                    this.dialog = false;
                })
            }
        }
    }
</script>