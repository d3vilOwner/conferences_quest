<template>
   <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title>UPDATE SUBCATEGORY</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form ref="form" v-model="validation.valid" lazy-validation>
                                    <v-text-field 
                                        v-model="subcategory.name" 
                                        :rules="validation.categoryNameRules" 
                                        label="Category name" 
                                        type="text"
                                        required
                                    ></v-text-field>
                                    <v-treeview
                                        v-model="selectedConferences"
                                        selectable
                                        :items="itemsConferences"
                                        :item-text="'title'"
                                    ></v-treeview>
                                    <v-treeview
                                        v-model="selectedReports"
                                        selectable
                                        :items="itemsReports"
                                        :item-text="'topic'"
                                    ></v-treeview>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-layout align-center justify-center>
                                    <v-btn
                                        dark
                                        color="grey darken-4"
                                        @click.prevent="update"
                                    >
                                        Edit
                                    </v-btn>
                                </v-layout>
                            </v-card-actions>
                        </v-card>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
export default {

    props: {
        subcategory: {
            type:Object,
            required:true
        },
        subcategoryID: {
            type:Object,
            required:true
        }
    },
    data() {
        return {
            selectedConferences: [],
            selectedReports: [],
            itemsConferences: [
                {
                    id:0,
                    title: 'Conferences',
              //      children: this.subcategory.conferences
                },
            ],
            itemsReports: [
                {
                    topic: 'Reports',
                //    children: this.subcategory.reports
                }
            ],
            validation: {
                valid: false,
                categoryNameRules: [
                    v => !!v || 'Title is required',
                ],
            }
        }
    },
    mounted() {

    },
    methods: {
        update() {

        }
    }
}
</script>