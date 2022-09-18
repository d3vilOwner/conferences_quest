import axios from "axios"

export default {
    state: {
        meetings: [],
    },
    mutations: {
        SET_MEETINGS(state, meetings) {
            state.meetings = meetings
        }
    }, 
    getters: {
        get_meetings(state) {
            return state.meetings
        }
    },
    actions: {
        getAllMeetings({commit}) {
            axios.get('/api/meeting/get-all-meetings').then(response => {
                console.log(response)
                if(typeof response.data.data !== 'undefined') {
                    commit('SET_MEETINGS', response.data.data.meetings)
                    console.log('no cache')
                } else {
                    commit('SET_MEETINGS', response.data.meetings)
                    console.log('has cache')
                }
            })
        }
    }
}