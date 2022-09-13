<template>
    <v-col>
        <v-card> 
            <v-card-text>
                <v-row align="center" justify="center">
                    <v-col>
                        <p class="text-h5 text--primary mb-0">
                            {{ category.name }}
                        </p>    
                    </v-col>
                    <v-btn 
                            v-if="(this.getCurrentUserRole === 'admin')" 
                            class="ml-3"
                            dark 
                            @click="destroyCategory"
                        >
                            Delete
                    </v-btn>
                    <v-btn 
                        dark 
                        class="ml-3"
                    >
                        <router-link 
                            class="nav-link" 
                            :to="{name: 'categoryDetails', params: {categoryId: category.id}}"
                        >
                            Details
                        </router-link>
                    </v-btn>
                    <v-btn 
                        dark 
                        v-if="(this.getCurrentUserRole === 'admin')" 
                        class="ml-3"
                    >
                        <router-link 
                            class="nav-link" 
                            :to="{name: 'updateCategory', params: {categoryId: category.id}}"
                        >
                            Edit
                        </router-link>
                    </v-btn>
                </v-row>
            </v-card-text>
        </v-card>
    </v-col>
</template>

<script>
import axios from 'axios';
import { mapActions, mapGetters } from 'vuex';

export default {
    props: {
        category: {
            type: Object,
            required: true
        },
    },
    computed: mapGetters(['getCurrentUserRole']),
    methods: {
        ...mapActions(['deleteCategory']),
        destroyCategory() {
            this.deleteCategory(this.category.id)
        },
        updateCategory() {

        }
    }

}
</script>