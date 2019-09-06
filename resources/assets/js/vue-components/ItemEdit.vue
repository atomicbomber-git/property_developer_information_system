<template>
    <form @submit.prevent="onFormSubmit">
        <div class='form-group'>
            <label for='name'> Name: </label>
            <input
                v-model='name'
                class='form-control'
                :class="{'is-invalid': get(this.error_data, 'errors.name[0]', false)}"
                type='text'
                id='name'
                placeholder='Name'>
            <div class='invalid-feedback'>
                 {{ get(this.error_data, 'errors.name[0]', false) }}
            </div>
        </div>

        <div class='form-group'>
            <label for='unit'> Unit: </label>
            <input
                v-model='unit'
                class='form-control'
                :class="{'is-invalid': get(this.error_data, 'errors.unit[0]', false)}"
                type='text'
                id='unit'
                placeholder='Unit'>
            <div class='invalid-feedback'>
                 {{ get(this.error_data, 'errors.unit[0]', false) }}
            </div>
        </div>

        <div class='form-group'>
            <label for='category_id'> Category: </label>
            <multiselect
                placeholder="Category"
                :allow-empty="false"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="categories"
                v-model="category"
            ></multiselect>
            <div
                v-if="get(this.error_data, 'errors.category_id[0]', false)"
                class='text-error'>
                {{ get(this.error_data, 'errors.category_id[0]', false) }}
            </div>
        </div>

        <div class='form-group'>
            <label for='note'> Note: </label>
            <textarea
                v-model='note'
                class='form-control'
                :class="{'is-invalid': get(this.error_data, 'errors.note[0]', false)}"
                type='text' id='note' placeholder='Note'></textarea>
            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.note[0]', false) }}</div>
        </div>

        <div class="form-group">
            <label> Vendor to Add: </label>
            <multiselect
                placeholder="Vendor"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="unpicked_vendors"
                v-model="picked_vendor"
            ></multiselect>
        </div>

        <div class="form-group">
            <label> Vendor List: </label>
            <table v-if="picked_vendors.length > 0" class="table table-sm table-striped table-bordered">
                <thead class="thead thead-dark">
                    <tr>
                        <th> Vendor </th>
                        <th class="text-center"> Controls </th>
                    </tr>
                </thead>

                <tbody>
                    <tr :key="i" v-for="(picked_vendor, i) in picked_vendors">
                        <td>
                            {{ picked_vendor.name }}
                        </td>
                        <td class="text-center">
                            <button
                                @click="picked_vendor.picked = false"
                                class="btn btn-sm btn-danger"
                                >
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div v-else class="alert alert-warning">
                <i class="fa fa-warning"></i>
                You haven't picked any vendor
            </div>
        </div>

        <div class="form-group d-flex justify-content-end">
            <button class="btn btn-primary btn-small">
                Update Item
                <i class="fa fa-check"></i>
            </button>
        </div>
    </form>
</template>

<script>

import { get } from 'lodash'
import Multiselect from 'vue-multiselect'

export default {
    props: [
        "submit_url", "redirect_url", "item", "vendors", "categories"
    ],

    components: { Multiselect },

    data() {
        return {
            name: this.item.name,
            unit: this.item.unit,
            m_vendors: this.vendors.map(vendor => ({
                ...vendor,
                picked: this.item.vendors.find(ven => ven.id === vendor.id) ? true : false
            })),
            category: this.categories.find(cat => cat.id === this.item.category_id) || null,
            note: this.item.note,

            picked_vendor: null,
            error_data: null,
        }
    },

    methods: {
        get,

        onFormSubmit() {
            axios.post(this.submit_url, this.form_data)
               .then(response => {
                    window.location.replace(this.redirect_url)
               })
               .catch(error => {
                   this.error_data = error.response.data
               })
        }
    },

    watch: {
        picked_vendor(vendor) {
            if (vendor !== null) {
                vendor.picked = true
                this.picked_vendor = null
            }
        }
    },

    computed: {
        form_data() {
            return {
                name: this.name,
                unit: this.unit,
                vendors: this.picked_vendors.map(vendor => vendor.id),
                category_id: this.category ? this.category.id : null,
                note: this.note,
            }
        },

        unpicked_vendors() {
            return this.m_vendors.filter(vendor => !vendor.picked)
        },

        picked_vendors() {
            return this.m_vendors.filter(vendor => vendor.picked)
        }
    }
}
</script>
