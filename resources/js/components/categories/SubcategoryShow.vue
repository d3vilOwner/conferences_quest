<template>
    <div>
        <v-card class="elevation-10 mb-5">
            <v-toolbar dark color="grey darken-4">
                <v-toolbar-title class="text-h5 mx-auto">{{ subcategory.name }}</v-toolbar-title>
            </v-toolbar>
            <v-card-text>
                <v-treeview
                    v-if="subcategory.conferences.length !== 0"
                    :items="itemsConferences"
                    :item-text="'title'"
                    class="text-h6"
                >
                </v-treeview>
                <v-treeview
                    v-if="subcategory.reports.length !== 0"
                    :items="itemsReports"
                    :item-text="'topic'"
                    class="text-h6"
                >
                </v-treeview>
                <p 
                    v-if="subcategory.reports.length === 0"
                    class="red--text text-h6"
                >
                    This subcategory no have any conferences
                </p>
                <p 
                    v-if="subcategory.conferences.length === 0"
                    class="red--text text-h6"
                >
                    This subcategory no have any reports
                </p>  
            </v-card-text>
            <v-card-actions>
                <!-- <v-btn v-if="this.getCurrentUserRole === 'admin'"><router-link class="nav-link" :to="{name: 'updateSubcategory', params: {subcategoryId: subcategory.id}}">Edit</router-link></v-btn> -->
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import axios from 'axios';
import { mapGetters } from 'vuex';

export default {
    props: {
        subcategory: {
            type:Object,
            required:true,
        }
    },
    mounted() {
        console.log(this.subcategory)
    },
    computed: mapGetters(['getCurrentUserRole']),
    data() {
        return {
            itemsConferences: [
                {
                    id: 0,
                    title: 'Conferences :',
                    children: this.subcategory.conferences,
                },
            ],
            itemsReports: [
                {
                    id: 0,
                    topic: 'Reports :',
                    children: this.subcategory.reports,
                },
            ], 
        }
    },
}
</script>