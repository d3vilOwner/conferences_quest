<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title>CREATE CATEGORY</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form ref="form" v-model="validation.valid" lazy-validation>
                                    <v-text-field 
                                        v-model="category.name" 
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
import axios from 'axios'
import router from '../../router/router'

export default {
    props: {
        conferences: {
            type:Array,
            required:true
        },
        reports: {
            type:Array,
            required:true
        },
        reportsInCategory: {
            type:Array,
            required:true
        },
        conferencesInCategory: {
            type:Array,
            required:true
        },
        category: {
            type:Object,
            required:true
        }
    },
    data() {
        return {
            selectedConferences: this.conferencesInCategory,
            selectedReports: this.reportsInCategory,
            name: this.categoryName,
            itemsConferences: [
                {
                    id:0,
                    title: 'Conferences',
                    children: this.conferences
                },
            ],
            itemsReports: [
                {
                    id:0,
                    topic: 'Reports',
                    children: this.reports
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
    methods: {
        update() {
            if(this.$refs.form.validate()) {
                axios.put('/api/category/update/'+this.category.id, {
                    name: this.category.name
                }).then(response => {
                    console.log(response)
                })

                axios.put('/api/category/conferences/'+this.category.id, this.selectedConferences).then(response => {
                    console.log(response)
                })

                this.selectedConferences.length = 0

                axios.put('/api/category/reports/'+this.category.id, this.selectedReports).then(response => {
                    console.log(response)
                })

                this.selectedReports.length = 0
                   

                router.push({name: 'categories'})
            } 

            console.log(this.selectedReports)
            console.log(this.category)
            console.log(this.selectedConferences)
        },
    }
}
</script>