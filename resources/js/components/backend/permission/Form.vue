<template>
    <modal :customClass="'sm'">
        <template  v-slot:header>
            <h4 class="col-sm-6 c-grey-900 p-20">
                <i class="c-blue-500 ti-user mR-15"></i>
                Permission form
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
                           v-model="permission.name"
                           class="form-control" placeholder="Name">
                    <div v-if="errors.first('name')"
                         class="invalid-feedback">{{ errors.first('name') }}</div>
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
    import modal from '@comp/lib/Modal'
    import alertify from 'alertifyjs'
    import client from '@/client'
    import {EventBus} from "@/event-bus"
    export default {
        name: "permission-form",
        components: {
            modal
        },
        data() {
            return {
            }
        },
        props: {
            method: {
                type: String,
                required: false,
                default: 'post'
            },
            permission: {
                type: Object,
                required: false,
                default: () => { return {}}
            }
        },
        methods: {
            formSubmit(){
                if (this.method && this.method === 'put')
                    return this.editPermission()
                return this.storePermission()
            },
            storePermission() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        client.post(route, this.permission)
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
            editPermission() {
                this.$validator.validateAll().then((result) => {
                    if (result) {
                        client.put(route + '/' + this.permission.id, this.permission)
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
            }
        }
    }
</script>

<style scoped>

</style>
