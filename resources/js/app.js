require('./bootstrap');

import Vue from 'vue'
import Vuetify from '../plugins/vuetify.js'
import * as VueGoogleMaps from 'vue2-google-maps'

import router from './router/router.js'
import store from './store/index.js'

import App from './App.vue'

Vue.use(VueGoogleMaps, {
  load: {
    key: 'AIzaSyArG1Qpk6EDTQVDAQwr1BgbmLY9pmb2ILY'
  },
  installComponents: true
})

const app = new Vue({
  components: {
    App,
  },
  vuetify: Vuetify,
  router,
  store
}).$mount('#app');