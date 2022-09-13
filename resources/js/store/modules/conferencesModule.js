import axios from "axios";
import router from '../../router/router.js'

export default {
    state: {
        conferences: [],
        conferenceDetails: {},
        countries: [],
    },
    mutations: {
        setConferences(state, payload) {
            state.conferences = payload;
        },
        setConferenceDetails(state, payload) {
            state.conferenceDetails = payload
        },
        setCountries(state, payload) {
            state.countries = payload
        },
        addConference(state, payload) {
            state.conferences.push(payload)
        },
        updateConference(state, payload) {
            state.conferences.forEach(function(stateConference, index, conference) {
                if(stateConference.id === payload.id) {
                    stateConference.id = payload.id
                    stateConference.title = payload.title
                    stateConference.latitude = payload.latitude
                    stateConference.longitude = payload.longitude
                    stateConference.conference_date = payload.conference_date
                    stateConference.user_id = payload.user_id
                    stateConference.country_id = payload.country_id
                }
            })
        },
        removeConference: (state, id) => state.conferences = state.conferences.filter((conferences) => conferences.id !== id),
    },
    getters: {
        getAllConferences(state) {
            return state.conferences;
        },
        getConferenceDetails(state) {
            return state.conferenceDetails
        },
        getCountries(state) {
            return state.countries
        }
    },
    actions: {
        async fetchConferences({commit}) {
            const response = await axios.get('/api/conferences');
            commit('setConferences', response.data.data)
        },
        async deleteConference({commit}, id) {
            await axios.delete(`/api/conference/${id}`)
            commit('removeConference', id); 
            router.push({name: 'conferencesList'})
        },
        async fetchConferenceDetails({commit}, id) {
            await axios.get('/api/conference/' + id).then(response => {
                commit('setConferenceDetails', response.data.data)
            }).catch( error => {
                console.log(error)
            })
        },
        async fetchCountries({commit}) {
            await axios.get('/api/countries').then(response => {
                commit('setCountries', response.data.data)
            })
        },
        async addConference({commit}, form) {
            await axios.post('/api/conference/store', {
                title: form.title,
                latitude: form.latitude,
                longitude: form.longitude,
                conference_date: form.conference_date,
                country_id: form.country_id,
                user_id: form.user_id,
            }).then(response => {
                commit('addConference', response.data.data)
                router.push({name: 'conferencesList'})
        //       console.log(response)
            }).catch(error => {
                console.log(error)
            })
        },
        async editConference({commit}, form) {
            await axios.put('/api/conference/'+form.id, {
                title: form.title,
                latitude: form.latitude,
                longitude: form.longitude,
                conference_date: form.conference_date,
                country_id: form.country_id,
                user_id: form.user_id.id,
            }).then(response => {
                commit('updateConference', response.data.data)
                router.push({name: 'conferencesList'})
            })
        },
    },
}