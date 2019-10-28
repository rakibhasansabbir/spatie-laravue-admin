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
                <tr v-for="(user, index) in users">
                    <td>{{ parseInt(index) + 1 }}</td>
                    <td><a class="text-primary" :href="'user/' + user.id">{{ user.name }}</a></td>
                    <td>{{ user.email ? user.email : '-' }}</td>
                    <td>
                        <template v-show="user.roles" v-for="(role, index) in user.roles">
                            <span class="badge badge-pill badge-info">{{role.name}}</span>
                        </template>
                    </td>
                    <td>
                        <a href="#" class="mL-5 mR-5 text-primary"
                               @click.prevent="showEditModal(user)"
                               data-toggle="tooltip"
                               title="Edit">
                                <i class="ti-pencil-alt"></i></a>
                        <a href="#" class="mL-5 mR-5 text-danger"
                           data-toggle="tooltip"
                           @click.prevent="deleteUser(user)"
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
       <user-form :data="editValue" method="put" v-show="showModal"></user-form>
    </div>
</template>

<script>
import client from '@/client'
import alertify from 'alertifyjs'
import UserForm from './Form'
import {Users} from "@/static/config/formColumn"
import {EventBus} from "@/event-bus";
export default {
    name: "permission-table",
        components: {
            UserForm
    },
    data() {
        return {
            loader: false,
            columns: Users.columns,
            users: [],
            webRoute: webRoute,
            showModal: false,
            editValue: {}
        }
    },
    mounted(){
        this.fetchUsers()
        EventBus.$on('modalClose', () => { this.showModal = false });
        EventBus.$on('refresh', () => { this.fetchUsers() });

    },
    methods:{
        fetchUsers() {
                client.get(route)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader = false
                            this.users = response.data
                            console.debug("users : ", this.users)
                        }
                    })
            },
        deleteUser(user){
             alertify.confirm('Permission delete', 'Are you sure?', () => {
                    client.delete(route + '/' + user.id)
                        .then(response => {
                            alertify.success(response.data.message)
                            this.fetchUsers();
                        })
            }, () => {});
        },
        showEditModal(data) {
            this.editValue = data
            console.debug("data :",  this.editValue)
            this.showModal = true
            this.method = 'put'
        },
    },

}
</script>

<style>

</style>
