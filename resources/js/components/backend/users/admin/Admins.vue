<template>
    <div class="table-responsive">
        <template v-if="!loader">
            <table v-if="admins.length > 0" class="table table-striped">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(admin, index) in admins">
                        <td>{{ index + 1 }}</td>
                        <td>{{ admin.name }}</td>
                        <td>{{ admin.email }}</td>
                        <td>
                            <div class="custom-control custom-switch">
                                <input type="checkbox"
                                       :checked="Boolean(admin.is_active)"
                                       @click.prevent="toggleAdmin(admin)"
                                       class="custom-control-input" :id="'adminStatus'+admin.id">
                                <label class="custom-control-label" :for="'adminStatus'+admin.id"
                                       v-text="Boolean(admin.is_active) ? 'Active':'Off'"></label>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="text-primary"
                               data-toggle="tooltip" title="Edit"
                                @click.prevent="editAdmin(admin)">
                                <i class="ti-pencil-alt"></i>
                            </a>
                            <a href="#" class="text-danger mL-15"
                               data-toggle="tooltip" title="delete"
                               @click.prevent="deleteAdmin(admin)">
                                <i class="ti-trash"></i>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p v-else class="text-info">No admin added yet</p>
        </template>
        <loader v-else></loader>
        <admin-form :admin="editValue"
            method="put"
            v-show="createModal"></admin-form>
    </div>
</template>

<script>
    import client from '@/client'
    import loader from '@comp/lib/Loader'
    import AdminForm from './Form'
    import alertify from 'alertifyjs'
    import {EventBus} from "@/event-bus"
    export default {
        name: "admins",
        components: {
            loader, AdminForm
        },
        data() {
            return {
                admins: [],
                loader: true,
                createModal: false,
                editValue: {}
            }
        },
        mounted() {
            this.fetchAdmins()
            EventBus.$on('modalClose', () => { this.createModal = false });
            EventBus.$on('refresh', () => { this.fetchAdmins() });
        },
        methods: {
            fetchAdmins() {
                client.get(route)
                    .then(response => {
                        console.log(response)
                        if (response.status >= 200 && response.status < 300) {
                            this.loader = false
                            this.admins = response.data
                        }
                    })
            },
            editAdmin(admin) {
                this.editValue = admin
                this.createModal = true
            },
            toggleAdmin(admin) {
                client.put(route + '/' + admin.id + '/toggle')
                    .then(response => {
                        if (response.status >= 200 && response.status < 300) {
                            alertify.success(response.data.message)
                            EventBus.$emit('refresh')
                        }
                    })
            },
            deleteAdmin(admin) {
                alertify.confirm('Admin delete', 'Are you sure?', () => {
                    client.delete(route + '/' + admin.id)
                        .then(response => {
                            alertify.success(response.data.message)
                            this.fetchAdmins();
                        })
                }, () => {});
            }
        },
        updated() {
            $('[data-toggle="tooltip"]').tooltip();
        },
        beforeDestroy() {
            EventBus.$off('modalClose')
            EventBus.$off('refresh')
        }
    }
</script>

<style scoped>

</style>