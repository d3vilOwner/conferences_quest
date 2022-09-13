<template>
    <UpdateSubcategoryForm
        :subcategory="+this.subcategory"
        :subcategoryID="this.subcategoryId"
    >
    </UpdateSubcategoryForm>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import UpdateSubcategoryForm from '../../components/categories/UpdateSubcategoryForm.vue';
export default {
    props: [
        'subcategoryId'
    ],
    components: {
        UpdateSubcategoryForm
    },
    data() {
        return {
            subcategory: null,
        }
    },
    computed: mapGetters(['getSubcategory']),
    methods: {
    //    ...mapActions(['fetchSubcategory']),
         fetchSubcategory() {
            axios.get('/api/category/subcategory/'+this.subcategoryId).then(response => {
                console.log(response.data)
                this.subcategory = response.data
            })
        }
    },
    mounted() {
        this.fetchSubcategory()
    //    console.log(this.getSubcategory)
    }
}
</script>