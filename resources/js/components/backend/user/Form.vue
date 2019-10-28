<template>
    <modal :customClass="'sm'">
        <template v-slot:header>
            <h4 class="col-sm-6 c-grey-900 p-20">
                <i class="c-blue-500 ti-user mR-15"></i>
                User form
            </h4>
        </template>
        <template v-slot:body>
            <form class="pL-20 pR-20 mB-20"
                  :class="{'was-validated': errors.length > 0}"
                  @submit.prevent="formSubmit"
                  method="post">
                <div class="form-group">
                    <label for="name"> Name </label>
                    <input type="text"
                           id="name"
                           v-validate="'required'"
                           :class="{'is-invalid':errors.first('name')}"
                           name="name"
                           v-model="data.name"
                           class="form-control" placeholder="Name">
                    <div v-if="errors.first('name')"
                         class="invalid-feedback">{{ errors.first('name') }}
                    </div>
                </div>
                <div class="form-group">
                    <label for="email"> Email </label>
                    <input type="email"
                           id="email"
                           v-validate="'required'"
                           :class="{'is-invalid':errors.first('email')}"
                           name="email"
                           v-model="data.email"
                           class="form-control" placeholder="Email">
                    <div v-if="errors.first('email')"
                         class="invalid-feedback">{{ errors.first('email') }}
                    </div>
                </div>
                <div v-if="method === 'put' && typeof data.roles !== 'undefined'" class="form-group">
                    <label>Roles</label>
                    <select v-model="data.roles" class="selectpicker form-control" multiple data-live-search="true" id="roles">
                        <template v-for="role in roles">
                            <option :value="role" >{{role.name}}</option>
                        </template>
                    </select>
                    <div v-if="errors.first('roles')"
                         class="invalid-feedback">{{ errors.first('roles') }}
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">
                        <i class="ti-upload mR-5"></i>
                        <span v-if="method === 'put'">Update</span>
                        <span v-else>Save</span>
                    </button>
                </div>
            </form>
        </template>
    </modal>
</template>

<script>
    import Modal from '@comp/lib/Modal'
    import alertify from 'alertifyjs'
    import client from '@/client'
    import {EventBus} from "@/event-bus"

    export default {
        name: "data-form",
        components: {
            Modal
        },
        data() {
            return {
                roles: []
            }
        },
        props: {
            method: {
                type: String,
                required: false,
                default: 'post'
            },
            data: {
                type: Object,
                required: false,
                default: () => {
                    return {}
                }
            }
        },
        mounted(){
            this.fetchRoles()
        },
        methods: {
            formSubmit() {
                if (this.method && this.method === 'put')
                    return this.edit()
                return this.store()
            },
            store() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        client.post(route, this.data)
                            .then(response => {
                                if (response.status >= 200 && response.status < 300) {
                                    EventBus.$emit('refresh')
                                    EventBus.$emit('modalClose')
                                    alertify.success(response.data.message)
                                }
                            })
                        return;
                    }
                    alertify.warning('Correct above errors!')
                });
            },
            edit() {
                let editData = this.data
                editData.roles = this.objectArrayToStringArray(editData.roles)
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        client.put(route + '/' + editData.id, editData)
                            .then(response => {
                                if (response.status === 422) {
                                    console.log(response)
                                }
                                if (response.status >= 200 && response.status < 300) {
                                    EventBus.$emit('refresh')
                                    EventBus.$emit('modalClose')
                                    alertify.success(response.data.message)
                                }
                            })
                        return;
                    }
                    alertify.warning('Correct above errors!')
                });
            },
            fetchRoles() {
                client.get(roleRoute)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader = false;
                            this.roles = response.data
                            console.debug("roles : ", this.roles)
                        }
                    })
            },
            objectArrayToStringArray(array){
                return array.map(function(item) {
                    return item['id'];
                });
            }
        }
    }
</script>

<style scoped>

</style>
