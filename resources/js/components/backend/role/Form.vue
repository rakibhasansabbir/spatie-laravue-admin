<template>
    <modal :customClass="'sm'">
        <template v-slot:header>
            <h4 class="col-sm-6 c-grey-900 p-20">
                <i class="c-blue-500 ti-user mR-15"></i>
                Role form
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
                <div v-if="method === 'put' && typeof data.permissions !== 'undefined'" class="form-group">
                    <label>Søger</label>
                    <select v-model="data.permissions" class="selectpicker form-control" multiple data-live-search="true">
                        <template v-for="permission in permissions">
                            <option :value="permission" >{{permission.name}}</option>
                        </template>
                    </select>
                    <div v-if="errors.first('data_permission')"
                         class="invalid-feedback">{{ errors.first('data_permission') }}
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
                permissions:[]
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
        mounted() {
            this.fetchPermissions()
        },
        methods: {
            formSubmit() {
                if (this.method && this.method === 'put')
                    return this.edit()
                return this.store()
            },
            fetchPermissions() {
                client.get(permissionRoute)
                    .then(response => {
                        if (response.status === 200) {
                            this.loader = false;
                            this.permissions = response.data
                        }
                    })
            },
            store() {
                console.log("called store")
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
                editData.permissions = this.objectArrayToStringArray(editData.permissions)
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
            objectArrayToStringArray(array){
                return array.map(function(item) {
                    return item['id'];
                });
            }
        }
    }
</script>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
<style scoped>
    body {
        background: #e8cbc0;
        background: -webkit-linear-gradient(to right, #e8cbc0, #636fa4);
        background: linear-gradient(to right, #e8cbc0, #636fa4);
        min-height: 100vh;
    }

    .bootstrap-select .bs-ok-default::after {
        width: 0.3em;
        height: 0.6em;
        border-width: 0 0.1em 0.1em 0;
        transform: rotate(45deg) translateY(0.5rem);
    }

    .btn.dropdown-toggle:focus {
        outline: none !important;
    }
</style>
