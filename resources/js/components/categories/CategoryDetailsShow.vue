<template>
    <v-app id="inspire">
        <v-main>
            <v-container fluid fill-height>
                <v-layout align-center justify-center>
                    <v-flex xs12 sm8 md5>
                        <v-card class="elevation-10">
                            <v-toolbar dark color="grey darken-4">
                                <v-toolbar-title class="text-h5 mx-auto">{{ category.name }}</v-toolbar-title>
                            </v-toolbar>
                            <v-card-text>
                                <v-treeview
                                    v-if="category.conferences.length !== 0"
                                    :items="itemsConferences"
                                    :item-text="'title'"
                                    class="text-h6"
                                >
                                </v-treeview>
                                <v-treeview
                                    v-if="category.reports.length !== 0"
                                    :items="itemsReports"
                                    :item-text="'topic'"
                                    class="text-h6"
                                >
                                </v-treeview>
                                <p 
                                    class="red--text text-h6"
                                    v-if="category.conferences.length === 0"
                                >
                                    This category no have any conferences
                                </p>
                                <p 
                                    class="red--text text-h6"
                                    v-if="category.reports.length === 0"
                                >
                                    This category no have any reports
                                </p>
                            </v-card-text>
                            <v-card-actions>
                                <v-btn 
                                    dark 
                                    v-if="this.getCurrentUserRole === 'admin'"
                                >
                                    <router-link 
                                        
                                        class="nav-link" 
                                        :to="{name: 'createSubcategory', params: {categoryId: category.id}}"
                                    >
                                        Create subcategory
                                    </router-link>
                                        
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                        <h1 class="mt-5 mb-5">Subcategories</h1>
                        <SubcategoryShow
                            v-for="subcategory in subcategories"
                            :subcategory="subcategory"
                            :key="subcategory.id"
                            
                        >
                        </SubcategoryShow>
                    </v-flex>
                </v-layout>
            </v-container>
        </v-main>
    </v-app>
</template>

<script>
import axios from 'axios';
import SubcategoryShow from './SubcategoryShow.vue';
import { mapGetters } from 'vuex';
export default {
    components: {
        SubcategoryShow
    },
    props: {
        category: {
            type:Object,
            required:true
        }
    },
    data() {
        return {
            subcategories: null,
            itemsConferences: [
                {
                    id: 1,
                    title: 'Conferences :',
                    children: this.category.conferences,
                },
            ],
            itemsReports: [
                {
                    id: 2,
                    topic: 'Reports :',
                    children: this.category.reports,
                },
            ], 
        }
    },
    mounted() {
        this.fetchSubcategories()
    },
    computed: mapGetters(['getCurrentUserRole']),
    methods: {
        get() {
            console.log(this.category)
        },
        fetchSubcategories() {
            axios.get(`/api/category/${this.category.id}/subcategory/fetch`).then(response => {
            //    console.log(response)
                this.subcategories = response.data
            })  
        }
    }
}
</script>