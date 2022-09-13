import axios from "axios"

export default { 
    state: {
        subcategory: null,
    },
    mutations: {
        SET_SUBCATEGORY(state, subcategory) {
            state.subcategory = subcategory
        }
    },
    getters: {
        getSubcategory(state) {
            return state.subcategory
        }
    },
    actions: {
        fetchSubcategory({commit}, subcategory_id) {
            axios.get('/api/category/subcategory/'+subcategory_id).then(response => {
                console.log(response.data)
                commit('SET_SUBCATEGORY', response.data)
            })
        }
    },
}