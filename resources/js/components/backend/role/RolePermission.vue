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
                <tr v-for="(customer, index) in customers">
                    <td>{{ parseInt(index) + 1 }}</td>
                    <td><a class="text-primary" :href="'customers/' + customer.id">{{ customer.full_name }}</a></td>
                    <td>{{ customer.user ? customer.user.email : '-' }}</td>
                    <td>{{ customer.gender }}</td>
                    <td>{{ customer.readable_dob }}</td>
                    <td class="text-center">{{ customer.applications_count }}</td>
                    <td>
                        <div class="custom-control custom-switch">
                            <input type="checkbox"
                                   :checked="Boolean(customer.user.is_active)"
                                   @click.prevent="toggleCustomerActive(customer.id)"
                                   class="custom-control-input" :id="'customerStatus'+customer.id">
                            <label class="custom-control-label" :for="'customerStatus'+customer.id"
                                   v-text="Boolean(customer.user.is_active) ? 'Active':'Off'"></label>
                        </div>
                    </td>
                    <td>
                        <a :href="webRoute + '/' + customer.id" class="mL-5 mR-5 text-primary"
                           data-toggle="tooltip"
                           title="Detail">
                            <i class="ti-eye"></i></a>
                        <a href="#" class="mL-5 mR-5 text-danger"
                           data-toggle="tooltip"
                           @click.prevent="deleteCustomer(customer)"
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
    </div>
</template>

<script>
import {RolePermissions} from "../../../static/config/formColumn"
export default {
    data() {
        return {
            loader: false,
            columns: RolePermissions.columns,
            customers: [],
        }
    },

}
</script>

<style>

</style>
