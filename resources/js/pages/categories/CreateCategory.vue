<template>
    <CreateCategoryForm
        :conferences="this.getAllConferences"
        :reports="this.getReports"
    >
    </CreateCategoryForm>
</template>

<script>
import CreateCategoryForm from '../../components/categories/CreateCategoryForm.vue';
import { mapActions, mapGetters } from 'vuex';
export default {
    data() {
        return {

        }
    },
    components: {
        CreateCategoryForm
    },
    computed: mapGetters(['getAllConferences', 'getReports']),
    methods: {
        ...mapActions(['fetchConferences', 'fetchReports']),
    },
    mounted() {
        this.fetchConferences()
        this.fetchReports()
    }
}
</script>