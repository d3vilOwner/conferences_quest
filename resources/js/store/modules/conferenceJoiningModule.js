import axios from "axios";
import { P } from "vue-socialmedia-share";
import { mapGetters } from "vuex";
import router from '../../router/router.js'
import store from '../index';
/*
export default {
    state: {
        isJoin: false,
        joinedId: null,
    },
    mutations: {
        SET_ISJOIN(state, value) {
            state.isJoin = value
        },
        SET_JOINEDID(state, value) {
            state.joinedId = value
        }
    },
    getters: {
        getIsJoin(state) {
            console.log(state.isJoin)

            return state.isJoin
        },
        getJoinedId(state) {
            return state.joinedId
        }
    },
    actions: {
        isJoin({commit}, conferenceID, userID) {
            axios.get('api/conference/join/'+conferenceID, {
                conference_id: conferenceID,
                user_id: userID
            }).then(response => {
                console.log(response.data.length)
                if(response.data.length === 1) {
                    commit('SET_ISJOIN', true)
                    commit('SET_JOINEDID', response.data[0].id)
                } else {
                    commit('SET_ISJOIN', true)
                }
                
            })
        }
    }
}
*/

export default {
    state: {
        currentUserJoinedConferences: [],
        isJoined: false,
    },
    mutations: {
        SET_JOINED_CONFERENCES(state, element) {
            const joinedConference = {
                id: element.id,
                conference_id: element.conference_id
            }
            state.currentUserJoinedConferences.push(joinedConference)
        },
        SET_JOINED_CONFERENCES_ON_NULL(state) {
            state.currentUserJoinedConferences.length = []
        },
        REMOVE_JOINING(state, joinedID) {
            state.currentUserJoinedConferences = state.currentUserJoinedConferences
                .filter((currentUserJoinedConferences) => currentUserJoinedConferences.id !== joinedID)
        },
        SET_IS_JOIN(state, status) {
            state.isJoined = status
        }
    },
    getters: {
        getJoinedConferences(state) {
            return state.currentUserJoinedConferences
        },
        getIsJoined(state) {
            return state.isJoined
        }
    },
    actions: {
        async isJoin({commit}, params) {
    //        let i = 0
            if(this.getters.getJoinedConferences.length !== 0) {
                commit('SET_JOINED_CONFERENCES_ON_NULL')
            }
            await axios.get('/api/joins').then(response => {              
                response.data.forEach((element) => {
                    if(params.user_id === element.user_id) {
                        commit('SET_JOINED_CONFERENCES', element)
       //                 i++
                    }
                })
          //      console.log(i)
                console.log(this.getters.getJoinedConferences)
            })
        },
        setOnNull({commit}) {
            commit('SET_JOINED_CONFERENCES_ON_NULL')
        },
        async join({commit}, params) {
            axios.post('api/conference/join/'+params.conference_id, {
                conference_id: params.conference_id,
                user_id: params.user_id,
                conference_title: params.conference_title,
                username: params.username
            }).then(response => {
                console.log(response)
                commit('SET_JOINED_CONFERENCES', response.data)
            })
        },
        async cancelJoin({commit}, joinedID) {
            axios.delete('api/conference/join/'+joinedID).then(response => {
                commit('REMOVE_JOINING', joinedID)
            })
        },
        async getJoin({commit}, params) {
            commit('SET_IS_JOIN', false)
            axios.get('/api/conference/join/'+params.conference_id, {
                conference_id: params.conference_id,
                user_id: params.user_id
            }).then(response => {
                console.log(response)
                if(response.data.length >= 1) {
                    commit('SET_IS_JOIN', true)
                    console.log('joined')
                }
                
            })
        }
    }
}