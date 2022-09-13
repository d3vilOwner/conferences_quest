import axios from "axios";
import router from '../../router/router.js'
export default { 
    state: {
        reportDetails: {},
        reports: [],
    },
    mutations: {
        SET_REPORT_DETAILS(state, details) {
            state.reportDetails = details
        },
        SET_REPORTS(state, data) {
            state.reports = data
        },
        SET_REPORTS_ON_NULL(state) {
            state.reports.length=0;
        },
        REMOVE_REPORT: (state, id) => state.reports = state.reports.filter((reports) => reports.id !== id),
    },
    getters: {
        getReportDetails(state) {
            return state.reportDetails
        },
        getReports(state) {
            return state.reports
        }
    },
    actions: {
        fetchReport({commit}, id) {
            axios.get('/api/report/'+id).then(response => {
                commit('SET_REPORT_DETAILS', response.data.data)
            })
        },
        deleteReportAndJoining({commit}, report_id) {
            axios.delete('/api/report/delete/'+report_id).then(response => {
                console.log(response)
                router.push({name: 'conferencesList'})
            })
        },
        async fetchReports({commit}) {
            commit('SET_REPORTS_ON_NULL')
            await axios.get('/api/report/index').then(response => {
            //    console.log(response.data.data)
                this.reports = response.data.data
                commit('SET_REPORTS', response.data.data)
            })
        },
        deleteReport({commit}, params) {
            axios.delete(`/api/report/destroy/${params.report_id}/${params.conference_title}`).then(response => {
                console.log(response)
                commit('REMOVE_REPORT', params.report_id)
            })
        }
    }
}