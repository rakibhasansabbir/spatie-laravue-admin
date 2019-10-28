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
                    <td>
                        <a href="#" class="mL-5 mR-5 text-primary"
                               @click.prevent="showEditModal(role)"
                               data-toggle="tooltip"
                               title="Edit">
                                <i class="ti-pencil-alt"></i></a>
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
        <role-form
            :data="editValue"
            method="put"
            v-show="showModal">
        </role-form>
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
            showModal: false,
            editValue: {}
        }
    },
    mounted(){
        this.fetchRolePermissions()
        EventBus.$on('modalClose', () => { this.showModal = false });
        EventBus.$on('refresh', () => { this.fetchRolePermissions() });

    },
    methods:{
        fetchRolePermissions() {
                client.get(route)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader = false;
                            this.roles = response.data
                        }
                    })
            },
        deleteRole(role){
             alertify.confirm('Role delete', 'Are you sure?', () => {
                    client.delete(route + '/' + role.id)
                        .then(response => {
                            alertify.success(response.data.message)
                            this.fetchRolePermissions();
                        })
            }, () => {});
        },
        showEditModal(role) {
            // let temp = []
            // role.permissions.forEach(element => {
            //     temp.push(element.id)
            // });
            // role.permissions = temp
            this.editValue = role
            this.showModal = true
            this.method = 'put'
        },
    },

}
</script>

<style>

</style>
