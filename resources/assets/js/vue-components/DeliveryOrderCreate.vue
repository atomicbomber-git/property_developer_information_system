<template>
    <form @submit.prevent="onFormSubmit">
        <div class="form-group">
            <label for="vendor_id"> Vendor </label>
            <multiselect
                placeholder="Vendor"
                :allow-empty="false"
                selectLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="vendors"
                v-model="vendor"
                :preselect-first="true"
            ></multiselect>
        </div>
    </form>
</template>

<script>

import { Multiselect } from 'vue-multiselect'

export default {
    components: { Multiselect },

    props: [
        "submit_url",
        "redirect_url",
        "vendors",
        "storages",
        "users",
    ],

    data() {
        return {
            vendor: null,
            storage: null,
            user: null,
        }
    },

    methods: {
        onFormSubmit() {

        }
    }
}
</script>
