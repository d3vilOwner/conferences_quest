<template>
    <v-container fluid>
        <ReportDetailsShow
            :report="getReportDetails"
            :user_id="getCurrentUserID"
            :role="getCurrentUserRole"
        >
        </ReportDetailsShow>
    </v-container>
</template>

<script>
import axios from 'axios'
import ReportDetailsShow from '../../components/reports/ReportDetailsShow.vue'
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
        ReportDetailsShow
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