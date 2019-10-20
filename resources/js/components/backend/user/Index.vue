<template>
    <div class="bgc-white bd bdrs-3 p-20 mB-20 mT-15">
        <div class="row">
            <h4 class="col-sm-6 c-grey-900 mB-20">
                <i class="c-deep-purple-500 ti-user mR-15"></i>users
            </h4>
            <div class="col-sm-6">
                <div class="btn-group pull-right">
                    <button  type="button" class="btn btn-primary" @click="showModal = true"> New User</button>
                </div>
            </div>
        </div>
        <user-table></user-table>
        <user-form v-show="showModal"></user-form>
    </div>
</template>

<script>
import UserTable from './UserTable'
import UserForm from './Form'
import {EventBus} from "@/event-bus";
export default {
    name: "user-index",
        components: {
            UserTable, UserForm
        },
        data() {
            return {
                showModal: false
            }
        },
        mounted() {
            EventBus.$on('modalClose', () => { this.showModal = false });
        },
        beforeDestroy() {
            EventBus.$off('modalClose')
        }

}
</script>

<style>

</style>
