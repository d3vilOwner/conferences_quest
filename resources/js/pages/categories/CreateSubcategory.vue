<template>
    <CreateSubcategoryForm
        :category="this.getCategory"
    >
    </CreateSubcategoryForm>
</template>

<script>
import CreateSubcategoryForm from '../../components/categories/CreateSubcategoryForm.vue';
import { mapActions, mapGetters } from 'vuex';
export default {
    props: [
        'categoryId'
    ],
    components: {
        CreateSubcategoryForm
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