<template>
    <CategoryDetailsShow
        :category="this.getCategory"
    >
    </CategoryDetailsShow>
</template>

<script>
import CategoryDetailsShow from '../../components/categories/CategoryDetailsShow.vue';
import { mapActions, mapGetters } from 'vuex';
export default {
    props: [
        'categoryId'
    ],
    components: {
        CategoryDetailsShow
    },
    computed: mapGetters(['getCategory']),
    methods: {
        ...mapActions(['fetchCategory']),
    },
    mounted() {
        this.fetchCategory(this.categoryId)
    }
}
</script>