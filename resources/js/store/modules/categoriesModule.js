import axios from "axios"

export default { 
    state: {
        categories: [],
        category: null,
    },
    mutations: {
        SET_CATEGORIES_ON_NULL(state) {
            state.categories.length=0;
        },
        SET_CATEGORIES(state, response) {
            state.categories = response
        },
        REMOVE_CATEGORY: (state, category_id) => state.categories = state.categories.filter((categories) => categories.id !== category_id),
        SET_CATEGORY(state, category) {
            state.category = category
        }
    },
    getters: {
        getCategories(state) {
            return state.categories
        },
        getCategory(state) {
            return state.category
        }
    },
    actions: {
        fetchCategories({commit}) {
            commit('SET_CATEGORIES_ON_NULL')
            axios.get('/api/category/fetch').then(response => {
                commit('SET_CATEGORIES', response.data.data)
            })
        },
        deleteCategory({commit}, category_id) {
            axios.delete('/api/category/delete/'+category_id).then(response => {
                console.log(response)
                commit('REMOVE_CATEGORY', category_id)
            })
        },
        fetchCategory({commit}, id) {
            axios.get('/api/category/'+id).then(response => {
                console.log(response.data)
                commit('SET_CATEGORY', response.data)
          //      this.category = response.data

        /*        response.data.conferences.forEach(element => {
                    this.selectedConferences.push(element.id)
                });
                console.log(this.selectedConferences)

                response.data.reports.forEach(element => {
                    this.selectedReports.push(element.id)
                });
                console.log(this.selectedReports) */
            })
        }
    },
}