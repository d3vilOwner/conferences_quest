<template>
    <v-container fluid>
        <v-row>
            <v-col cols="3">
                <ReportFilterBlock @data="getData"></ReportFilterBlock>
            </v-col>
            <v-col cols="9"> 
                <ReportShow
                    v-for="report in filteredReports"
                    :report="report"
                    :key="report.id"
                >
                </ReportShow>
            </v-col>
        </v-row>
    </v-container>
</template>

<script>
import axios from 'axios'
import ReportShow from '../../components/reports/ReportShow.vue'
import ReportFilterBlock from '../../components/filter/ReportFilterBlock.vue'
export default {
    data() {
        return {
            reports: [],
            filter: {
                startTime: null,
                endTime: null,
                categories: [],
            },
        }
    },
    components: {
        ReportShow,
        ReportFilterBlock
    },
    methods: {
        fetchReports() {
            axios.get('api/report/index').then(response => {
           //     console.log(response.data.data)
                this.reports = response.data.data
            })
        },
        getData(data) {
            this.filter.startTime = data.startTime
            this.filter.endTime = data.endTime
            this.filter.categories = data.selectedCategories
            console.log(this.filter)
        },
        get() {
            console.log(this.reports)
        }
    },
    computed: {
        filteredReports() {
            return this.reports.filter((report) => {
                if(this.filter.startTime === null && this.filter.endTime === null && this.filter.categories.length === 0) {
                    return report
                } else {

                    if(this.filter.startTime !== null && this.filter.endTime === null && this.filter.categories.length === 0) { // only start time
                        return report.report_start > this.filter.startTime
                    } else if(this.filter.startTime === null && this.filter.endTime !== null && this.filter.categories.length === 0) { // only end time
                        return report.report_end < this.filter.endTime
                    } else if(this.filter.startTime === null && this.filter.endTime === null && this.filter.categories.length !== 0) { // only categories
                        if(report.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(report.category_id.name === this.filter.categories[i]) {
                                    return report
                                }
                            }
                        }
                    } else if(this.filter.startTime !== null && this.filter.endTime === null && this.filter.categories.length !== 0) { // only categories && start time
                        if(report.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(report.category_id.name === this.filter.categories[i] && report.report_start > this.filter.startTime) {
                                    return report 
                                }
                            }
                        }
                    } else if(this.filter.startTime === null && this.filter.endTime !== null && this.filter.categories.length !== 0) { // only categories && end time
                        if(report.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(report.category_id.name === this.filter.categories[i] && report.report_end < this.filter.endTime) {
                                    return report 
                                }
                            }
                        }
                    } else if(this.filter.startTime !== null && this.filter.endTime !== null && this.filter.categories.length === 0) { // only start && end time
                        return report.report_start > this.filter.startTime && report.report_end < this.filter.endTime
                    } else if(this.filter.startTime !== null && this.filter.endTime !== null && this.filter.categories.length !== 0) { // only categories && end time
                        if(report.category_id !== null) {
                            for(var i = 0; i < this.filter.categories.length; i++) {
                                if(report.category_id.name === this.filter.categories[i] && report.report_end < this.filter.endTime && report.report_start > this.filter.startTime) { // start && end && categories
                                    return report 
                                }
                            }
                        }
                    } 
                }
            })
        }
    },
    mounted() {
        this.fetchReports()
    }
}
</script>

