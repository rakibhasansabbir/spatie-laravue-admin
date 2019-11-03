<template>
    <div class="bgc-white bd bdrs-3 p-20 mB-20 mT-15">
        <div class="row">
            <h4 class="col-sm-6 c-grey-900 mB-20">
                <i class="c-deep-purple-500 ti-user mR-15"></i>Role Permissions
            </h4>
            <div class="col-sm-6">
                <div class="btn-group pull-right">
                    <button type="button" class="btn btn-primary" @click="showModal = true"> New Role</button>
                </div>
            </div>
        </div>
        <role-permission></role-permission>
        <role-form v-show="showModal"></role-form>
    </div>
</template>

<script>
    import RolePermission from './RolePermission'
    import RoleForm from './Form'
    import {EventBus} from "@/event-bus";

    export default {
        name: "admin-page",
        components: {
            RolePermission, RoleForm
        },
        data() {
            return {
                showModal: false,
                changePermissionModal: false
            }
        },
        mounted() {
            EventBus.$on('modalClose', () => {
                this.showModal = false
            });
        },
        beforeDestroy() {
            EventBus.$off('modalClose')
        }

    }
</script>

<style>

</style>
