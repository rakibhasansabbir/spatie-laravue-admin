import Vue from 'vue'

// dashboard components
Vue.component('admin-dashboard', require('../components/backend/dashboard/Dashboard.vue').default);
// ====================== Role ===================================
Vue.component('role-index', require('../components/backend/role/index.vue').default);
Vue.component('role-permission', require('../components/backend/role/RolePermission.vue').default);
