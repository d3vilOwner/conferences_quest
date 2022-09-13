<template>
    <UpdateCategoryForm
        :conferences="this.getAllConferences"
        :reports="this.getReports"
        :conferencesInCategory="selectedConferences"
        :reportsInCategory="selectedReports"
        :category="this.getCategory"
    >
    </UpdateCategoryForm>
</template>

<script>
import UpdateCategoryForm from '../../components/categories/UpdateCategoryForm.vue';
import { mapActions, mapGetters } from 'vuex';
import axios from 'axios';
export default {
    props: [
        'categoryId'
    ],
    data() {
        return {
            selectedConferences: [],
            selectedReports: [],
            categoryName: '',
            category: null,
        }
    },
    components: {
        UpdateCategoryForm,
    },
    computed: mapGetters(['getAllConferences', 'getReports', 'getCategory']),
    methods: {
        ...mapActions(['fetchConferences', 'fetchReports', 'fetchCategory']),
        getCategoryObject() {
            this.category = this.getCategory

            this.selectedConferences.length=0
            this.selectedReports.length=0


            this.category.conferences.forEach(element => {
                this.selectedConferences.push(element.id)
            });
            console.log(this.selectedConferences)

            this.category.reports.forEach(element => {
                this.selectedReports.push(element.id)
            });
            console.log(this.selectedReports)
         //   console.log(this.getCategory)
        /*    axios.get('/api/category/'+this.categoryId).then(response => {
                console.log(response.data)
                this.category = response.data

                response.data.conferences.forEach(element => {
                    this.selectedConferences.push(element.id)
                });
                console.log(this.selectedConferences)

                response.data.reports.forEach(element => {
                    this.selectedReports.push(element.id)
                });
                console.log(this.selectedReports)
            }) */
        },
    },
    mounted() {
        this.fetchConferences()
        this.fetchReports()
        this.fetchCategory(this.categoryId)
        this.getCategoryObject()
    },

}
</script>