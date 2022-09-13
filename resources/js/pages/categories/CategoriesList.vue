<template>
    <v-container>
        <v-btn dark v-if="user_role === 'admin'" class="ml-3 mb-3"><router-link class="nav-link" :to="{name: 'createCategory'}">Create Category</router-link></v-btn>
        <CategoryShow
            v-for="category in this.getCategories"
            :category="category"
            :key="category.id"
        >
        </CategoryShow>
    </v-container>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import CategoryShow from '../../components/categories/CategoryShow.vue';
export default {
    components: {
        CategoryShow
    },
    data() {
        return {
            user_role: null,
        }
    },
    mounted() {
        this.fetchCategories()
        this.user_role = this.getCurrentUserRole
        console.log(this.user_role)
    },
    computed: mapGetters(['getCategories', 'getCurrentUserRole']),
    methods: {
        ...mapActions(['fetchCategories']),
    }
}
</script>