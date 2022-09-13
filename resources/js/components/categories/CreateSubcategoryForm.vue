<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md4>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title>CREATE SUBCATEGORY</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-form ref="form" v-model="validation.valid" lazy-validation>
                                    <v-text-field
                                        v-model="form.subCategoryName"
                                        :rules="validation.categoryNameRules" 
                                        label="Subcategory name" 
                                        type="text"
                                        required
                                    ></v-text-field>
                                    <v-treeview
                                        v-if="category.conferences.length !== 0"
                                        v-model="selectedConferences"
                                        selectable
                                        :items="itemsConferences"
                                        :item-text="'title'"
                                    ></v-treeview>
                                    <p 
                                        class="red--text text-h6"
                                        v-if="category.conferences.length === 0"
                                    >
                                        You cannot add conferences to this subcategory
                                    </p>
                                    <v-treeview
                                        v-if="category.reports.length !== 0"
                                        v-model="selectedReports"
                                        :items="itemsReports"
                                        selectable
                                        :item-text="'topic'"
                                    ></v-treeview>
                                    <p 
                                        class="red--text text-h7"
                                        v-if="category.reports.length === 0"
                                    >
                                        You cannot add reports to this subcategory
                                    </p>
                                </v-form>
                            </v-card-text>
                            <v-card-actions>
                                <v-layout align-center justify-center>
                                    <v-btn
                                        dark
                                        color="grey darken-4"
                                        @click.prevent="create"
                                    >
                                        Create
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
import axios from 'axios';
import router from '../../router/router';

export default {
    props: {
        category: {
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
                    children: this.category.conferences
                },
            ],
            itemsReports: [
                {
                    topic: 'Reports',
                    children: this.category.reports
                }
            ],
            form: {
                subCategoryName: '',
            },
            validation: {
                valid: false,
                categoryNameRules: [
                    v => !!v || 'Title is required',
                ],
            }
        }
    },
    methods: {
        create() {
            console.log(this.selectedReports)
            if(this.$refs.form.validate()) {
                axios.post('/api/category/subcategory/store', {
                    name: this.form.subCategoryName,
                    category_id: this.category.id
                }).then(response => {
                    console.log(response)
                    if(this.selectedConferences.length !== 0) {
                        axios.put(`/api/category/subcategory/conferences/${this.category.id}/${response.data.data.id}`, this.selectedConferences).then(response => {
                            console.log(response)
                        })

                        this.selectedConferences.length = 0
                    }

                    if(this.selectedReports.length !== 0) {
                        axios.put(`/api/category/subcategory/reports/${this.category.id}/${response.data.data.id}`, this.selectedReports).then(response => {
                            console.log(response)
                        })

                        this.selectedReports.length = 0
                    }   

                    console.log(response)
                    router.push({name: 'categoryDetails', params: {categoryId: this.category.id}})
                })
               
            }
        },
    }
}
</script>

