<template>
    <UpdateReport
        :report="this.getReportDetails"
    >
    </UpdateReport>
</template>

<script>
import UpdateReport from '../../components/reports/UpdateReportForm.vue'
import { mapActions, mapGetters } from 'vuex'
export default {
    data() {
        return {
            report: null,
            user_id: null,
            role: null,
        }
    },
    props: [
        'reportId'
    ],
    components: {
        UpdateReport
    },
    computed: mapGetters(['getReportDetails', 'getCurrentUserRole', 'getCurrentUserID']),
    methods: {
        ...mapActions(['fetchReport']),
        fetchReportDetails() {
            this.fetchReport(this.reportId)
        },
    },
    mounted() {
        this.fetchReportDetails()
    }
}
</script>