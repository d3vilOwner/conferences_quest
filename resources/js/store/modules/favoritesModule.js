import axios from "axios"

export default { 
    state: {
        favorites: [],
    },
    mutations: {
        SET_FAVORITES(state, favorites) {
            state.favorites = favorites
        },
        SET_FAVORITES_ON_NULL(state) {
            state.favorites.length = 0
        }
    },
    getters: {
        getFavorites(state) {
            return state.favorites
        }
    },
    actions: {
        fetchCurrentUserFavorites({commit}, user_id) {
            commit('SET_FAVORITES_ON_NULL')
            axios.get('/api/favorite/'+user_id).then(response => {
        //        console.log(response)
                commit('SET_FAVORITES', response.data)
            })
        },
    },
}