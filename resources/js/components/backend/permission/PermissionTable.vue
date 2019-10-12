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
                <tr v-for="(permission, index) in permissions">
                    <td>{{ parseInt(index) + 1 }}</td>
                    <td><a class="text-primary" :href="'permission/' + permission.id">{{ permission.name }}</a></td>
                    <td>{{ permission.guard_name ? permission.guard_name : '-' }}</td>
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
                        <a href="#" class="mL-5 mR-5 text-primary"
                               @click.prevent="showEditModal(permission)"
                               data-toggle="tooltip"
                               title="Edit">
                                <i class="ti-pencil-alt"></i></a>
                        <a href="#" class="mL-5 mR-5 text-danger"
                           data-toggle="tooltip"
                           @click.prevent="deletePermission(permission)"
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
                <permission-form :permission="editValue"
            method="put"
            v-show="showModal"></permission-form>
    </div>
</template>

<script>
import client from '@/client'
import alertify from 'alertifyjs'
import PermissionForm from './Form'
import {Permissions} from "@/static/config/formColumn"
import {EventBus} from "@/event-bus";
export default {
    name: "permission-table",
        components: {
            PermissionForm
    },
    data() {
        return {
            loader: false,
            columns: Permissions.columns,
            permissions: [],
            webRoute: webRoute,
            showModal: false,
            editValue: {}
        }
    },
    mounted(){
        this.fetchPermissions()
        EventBus.$on('modalClose', () => { this.showModal = false });
        EventBus.$on('refresh', () => { this.fetchPermissions() });

    },
    methods:{
        fetchPermissions() {
                client.get(route)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader = false;
                            this.permissions = response.data
                            console.debug("permission : ", response)
                        }
                    })
            },
        deletePermission(permission){
             alertify.confirm('Permission delete', 'Are you sure?', () => {
                    client.delete(route + '/' + permission.id)
                        .then(response => {
                            alertify.success(response.data.message)
                            this.fetchPermissions();
                        })
            }, () => {});
        },
        showEditModal(permission) {
            this.editValue = permission
            this.showModal = true
            this.method = 'put'
        },
    },

}
</script>

<style>

</style>
