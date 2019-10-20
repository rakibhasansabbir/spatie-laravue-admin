import Vue from 'vue'

// dashboard components
Vue.component('admin-dashboard', require('../components/backend/dashboard/Dashboard.vue').default);
// ====================== Role ===================================
Vue.component('role-index', require('../components/backend/role/index.vue').default);
Vue.component('permission-index', require('../components/backend/permission/index.vue').default);
Vue.component('user-index', require('../components/backend/user/Index.vue').default);
