require('./bootstrap');
require('./include/adminComponent');
import Vue from 'vue'
import VeeValidate from 'vee-validate';
import Multiselect from 'vue-multiselect'

// register globally
Vue.component('multiselect', Multiselect)
Vue.use(VeeValidate);


const app = new Vue({
    el: '#app'
});
