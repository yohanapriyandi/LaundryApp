<template>
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title">Create New Transaction</h3>
            </div>

            <div class="panel-body">
                <transaction-form ref="form"></transaction-form>
                <div class="form-group">
                    <button class="btn btn-microsoft btn-sm btn-flat" @click.prevent="submit">
                        <i class="fa fa-save"> Create Transaction</i>
                    </button>
                    <!-- tombol dengan fungsi untuk mengosongkan form  -->
                     <button class="btn btn-microsoft btn-sm btn-flat" @click.prevent="clearForm">
                        <i class="fa fa-save"> Clear Form</i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { mapActions, mapState, mapMutations } from 'vuex'
import FormTransaction from './Form.vue'
export default {
    name: 'AddTransaction',

    methods: {
        submit() {
            this.$refs.form.submit()
        },
        clearForm() {
            this.$refs.form.resetForm()
        }
    },

    components: {
         'transaction-form': FormTransaction
    }
}
</script>