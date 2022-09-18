import Vue from 'vue'
import Vuex from 'vuex'
import createPersistedState from "vuex-persistedstate";

import conferencesModule from './modules/conferencesModule.js'
import authModule from './modules/authModule.js'
import conferenceJoiningModule from './modules/conferenceJoiningModule.js'
import reportsModule from './modules/reportsModule.js'
import commentsModule from './modules/commentsModule.js'
import categoriesModule from './modules/categoriesModule.js'
import subcategoriesModule from './modules/subcategoriesModule.js'
import favoritesModule from './modules/favoritesModule.js'
import meetingsModule from './modules/meetingsModule.js'

Vue.use(Vuex)

const store = new Vuex.Store({
    modules: {
        conferencesModule,
        authModule,
        conferenceJoiningModule,
        reportsModule,
        commentsModule,
        categoriesModule,
        subcategoriesModule,
        favoritesModule,
        meetingsModule
    },
    plugins: [createPersistedState()],
})
window.Store = store

export default store 
