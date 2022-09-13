import axios from "axios";
import router from '../../router/router.js'
export default { 
    state: {
        token: null,
        userID: null,
        role: null,
        error: false,
        user: null,
    },
    mutations: {
        SET_TOKEN(state, token) {
            localStorage.setItem('x-xsrf-token', token)
            state.error = false
            state.token = localStorage.getItem('x-xsrf-token')
        },
        SET_USER_ID(state, userID) {
            state.userID = userID
        },
        SET_ROLE(state, role) {
            state.role = role
        },
        SET_ERROR(state) {
            state.error = true
        },
        SET_USER(state, user) {
            state.user = user
        },
        
        REMOVE_TOKEN(state) {
            localStorage.removeItem('x-xsrf-token')
            state.token = null
        },
        REMOVE_USER_ID(state) {
            state.userID = null
        },
        REMOVE_ROLE(state) {
            state.role = null
        },
        REMOVE_ERROR(state) {
            state.error = false
        },
        REMOVE_USER(state) {
            state.user = null
        }

    },
    getters: {
        getCurrentUserToken(state) {
            return state.token
        },
        getCurrentUserID(state) {
            return state.userID
        },
        getCurrentUserRole(state) {
            return state.role
        },
        getErrorStatus(state) {
            return state.error
        },
        getUser(state) {
            return state.user
        }
    },
    actions: {
        login({commit}, form) {
            axios.get('sanctum/csrf-cookie').then(response => {
                axios.post('/login', {
                    email: form.email,
                    password: form.password
                }).then( r => {
                    if(r.data == 'Cannot find user with this credentials') {
                        commit('SET_ERROR', true)       
                    } else {
                        console.log(r)
                        commit('SET_TOKEN', r.config.headers['X-XSRF-TOKEN'])
                        commit('SET_USER_ID', r.data.id)
                        commit('SET_ROLE', r.data.role)
                        commit('SET_USER', r.data)
                        router.push({name: 'conferencesList'})
                    }                 
                }).catch(error => {
                    commit('SET_ERROR', true)       
            //     console.log("ERRRR:: ",error.response);
                });
            })
        },
        logout({commit}) {
            axios.post('/logout')
                .then( res => {
                    commit('REMOVE_TOKEN')
                    commit('REMOVE_USER_ID')
                    commit('REMOVE_ROLE')
                    commit('REMOVE_ERROR')
                    commit('REMOVE_USER')
                //    localStorage.removeItem('x-xsrf-token')
                    router.push({name: 'login'})
                })
        },
        register({commit}, form) {
            axios.get('sanctum/csrf-cookie').then(response => {
                axios.post('/register', {
                    firstname: form.firstname,
                    lastname: form.lastname,
                    role: form.role,
                    country_id: form.country_id,
                    birthdate: form.birthdate,
                    email: form.email,
                    phone: form.phone,
                    password: form.password,
                    password_confirmation: form.password_confirmation
                }).then( r => {
                    console.log(r)
                    commit('SET_TOKEN', r.config.headers['X-XSRF-TOKEN'])
                    commit('SET_USER_ID', r.data.id)
                    commit('SET_ROLE', r.data.role)
                    commit('SET_USER', r.data)
                    router.push({name: 'conferencesList'})
                }).catch(error => {
                    console.log("ERRRR:: ",error.response.data);
                });  
            }) 
        }
    }
}