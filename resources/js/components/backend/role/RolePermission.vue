<template>
   <div class="table-responsive">
        <template v-if="!loader" >
            <table  class="table table-striped">
                <thead>
                <tr>
                    <th v-for="column in columns">{{ column }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(role, index) in roles">
                    <td>{{ parseInt(index) + 1 }}</td>
                    <td><a class="text-primary" :href="'role/' + role.id">{{ role.name }}</a></td>
                    <td>{{ role.guard_name ? role.guard_name : '-' }}</td>
                    <td>
                        <template v-show="role.permissions" v-for="(permission, index) in role.permissions">
                            <span class="badge badge-pill badge-info">{{permission.name}}</span>
                        </template>
                    </td>
                    <!-- <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox"
                                   :checked="Boolean(customer.user.is_active)"
                                   @click.prevent="toggleCustomerActive(customer.id)"
                                   class="custom-control-input" :id="'customerStatus'+customer.id">
                            <label class="custom-control-label" :for="'customerStatus'+customer.id"
                                   v-text="Boolean(customer.user.is_active) ? 'Active':'Off'"></label>
                        </div>
                    </td> -->
                    <td>
                        <!-- <a :href="webRoute + '/' + role.id" class="mL-5 mR-5 text-primary"
                           data-toggle="tooltip"
                           title="Detail">
                            <i class="ti-eye"></i></a> -->
                        <a href="#" class="mL-5 mR-5 text-danger"
                           data-toggle="tooltip"
                           @click.prevent="deleteRole(role)"
                           title="Delete">
                            <i class="ti-trash"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </template>
        <!-- <template v-else>
            <Loader></Loader>
        </template> -->
                <role-form :role="editValue"
            method="put"
            v-show="createModal"></role-form>
    </div>
</template>

<script>
import client from '@/client'
import alertify from 'alertifyjs'
import RoleForm from './Form'
import {RolePermissions} from "@/static/config/formColumn"
import {EventBus} from "@/event-bus";
export default {
    name: "role-permission",
        components: {
            RoleForm
    },
    data() {
        return {
            loader: false,
            columns: RolePermissions.columns,
            roles: [],
            webRoute: webRoute,
            createModal: false,
            editValue: {}
        }
    },
    mounted(){
        this.fetchRolePermissions()
        EventBus.$on('modalClose', () => { this.createModal = false });
        EventBus.$on('refresh', () => { this.fetchRolePermissions() });

    },
    methods:{
        fetchRolePermissions() {
                client.get(route)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader = false;
                            this.roles = response.data
                            console.debug("role permissions : ", this.roles)
                        }
                    })
            },
        deleteRole(role){
            console.debug("role details:", role)
             alertify.confirm('Role delete', 'Are you sure?', () => {
                    client.delete(route + '/' + role.id)
                        .then(response => {
                            alertify.success(response.data.message)
                            this.fetchRolePermissions();
                        })
            }, () => {});
        }
    },

}
</script>

<style>

</style>
