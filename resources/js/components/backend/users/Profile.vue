<template>
    <div class="bgc-white bd bdrs-3 p-20 mB-20 mT-15">
        <div class="row">
            <h4 class="col-sm-6 c-grey-900 mB-20">
                <i class="c-indigo-500 ti-user mR-15"></i>Profile Detail
            </h4>
            <div class="col-sm-6">
                <div class="btn-group pull-right">
                    <a href="#" onclick="window.history.back()" class="btn btn-primary">
                        <i class="ti-angle-left"></i></a>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6">
                <div class="bd bdrs-3 p-20">
                    <p><b>Update info form: </b></p><hr>
                    <form @submit.prevent="updateProfile('user-update')" data-vv-scope="user-update">
                        <div class="form-group">
                            <label for="name"><b>Name</b></label>
                            <input type="text" name="name"
                                   v-model="user.name"
                                   v-validate="'required'"
                                   :class="{'is-invalid':errors.first('user-update.name')}"
                                   class="form-control" placeholder="Lender Name">
                            <div v-if="errors.first('user-update.name')"
                                 class="invalid-feedback">{{ errors.first('user-update.name') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="email"><b>Email</b></label>
                            <input type="text" name="email"
                                   v-model="user.email"
                                   v-validate="'required|email'"
                                   :class="{'is-invalid':errors.first('user-update.email')}"
                                   class="form-control" placeholder="Email">
                            <div v-if="errors.first('user-update.email')"
                                 class="invalid-feedback">{{ errors.first('user-update.email') }}</div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="ti-upload"></i>Update profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="bd bdrs-3 p-20">
                    <p><b>Update password form: </b></p><hr>
                    <form @submit.prevent="updatePassword('password-update')" method="put" data-vv-scope="password-update">
                        <div class="form-group">
                            <label for="current"><b>Current Password</b></label>
                            <input type="password" name="current"
                                   v-model="password.current"
                                   v-validate="'required|min:6'"
                                   :class="{'is-invalid':errors.first('password-update.current')}"
                                   class="form-control" placeholder="Current password">
                            <div v-if="errors.first('password-update.current')"
                                 class="invalid-feedback">{{ errors.first('password-update.current') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="new_password"><b>New Password</b></label>
                            <input type="password" name="new_password"
                                   v-model="password.password"
                                   ref="password"
                                   v-validate="'required|min:6'"
                                   :class="{'is-invalid':errors.first('password-update.new_password')}"
                                   class="form-control" placeholder="New Password">
                            <div v-if="errors.first('password-update.new_password')"
                                 class="invalid-feedback">{{ errors.first('password-update.new_password') }}</div>
                        </div>
                        <div class="form-group">
                            <label for="confirm_password"><b>Confirm Password</b></label>
                            <input type="password" name="confirm_password"
                                   v-model="password.password_confirmation"
                                   v-validate="'required|confirmed:password|min:6'"
                                   :class="{'is-invalid':errors.first('password-update.confirm_password')}"
                                   class="form-control" placeholder="Confirm password">
                            <div v-if="errors.first('password-update.confirm_password')"
                                 class="invalid-feedback">{{ errors.first('password-update.confirm_password') }}</div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-dark"><i class="ti-crown"></i>Update password</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import client from '@/client'
    import alertify from 'alertifyjs'
    import {EventBus} from "@/event-bus";
    export default {
        name: "backend-profile",
        components: {},
        data() {
            return {
                load: false,
                user: {},
                password: {},
            }
        },
        mounted() {
            this.fetchUser();
        },
        methods: {
            fetchUser() {
                client.get(route)
                    .then(response => {
                        console.log(response)
                        this.user = response.data
                    })
            },
            updateProfile(scope) {
                let self = this
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        client.put(route, self.user)
                            .then(response => {
                                if (response.status === 200) {
                                    alertify.success(response.data.message)
                                }
                            });
                        return;
                    }
                    alertify.warning('Correct above errors!')
                });
            },
            updatePassword(scope) {
                let self = this
                this.$validator.validateAll(scope).then((result) => {
                    if (result) {
                        client.put(route + '/password', self.password)
                            .then(response => {
                                if (response.status === 200) {
                                    self.password = {}
                                    EventBus.$emit('modalClose');
                                    alertify.success(response.data.message)
                                }
                            });
                        return;
                    }
                    alertify.warning('Correct above errors!')
                });
            },
        }
    }
</script>

<style scoped>

</style>