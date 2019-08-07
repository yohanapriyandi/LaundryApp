import Vue from 'vue'
import router from './router.js'
import store from './store.js'
import App from './App.vue'

// Bootstrap-Vue
import BootstrapVue from 'bootstrap-vue'
// vueSweetalert
import VueSweetalert2 from 'vue-sweetalert2'

// Use them

Vue.use(BootstrapVue)
Vue.use(VueSweetalert2)

import 'bootstrap-vue/dist/bootstrap-vue.css'

new Vue({
    el:"#dw",
    router,
    store,
    components: {
        App
    }

})
