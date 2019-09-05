<template>
    <form @submit.prevent="onFormSubmit">
        <div class='form-group'>
            <label for='receiver_id'> Receiver: </label>
            <multiselect
                placeholder="Receiver"
                :allow-empty="false"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="users"
                v-model="receiver"
                :preselect-first="true"
            ></multiselect>
            <div v-if="get(this.error_data, 'errors.receiver_id[0]', false)" class='text-danger'>
                {{ get(this.error_data, 'errors.receiver_id[0]', false) }}
            </div>
        </div>

        <div class='form-group'>
            <label for='storage_id'> Storage: </label>
            <multiselect
                placeholder="Storage"
                :allow-empty="false"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="storages"
                v-model="storage"
                :preselect-first="true"
            ></multiselect>
            <div v-if="get(this.error_data, 'errors.storage_id[0]', false)" class='text-danger'>
                {{ get(this.error_data, 'errors.storage_id[0]', false) }}
            </div>
        </div>

        <div class='form-group'>
            <label for='received_at'> Receivement Date: </label>
            <input
                type="date"
                v-model='received_at'
                class='form-control'
                :class="{'is-invalid': get(this.error_data, 'errors.received_at[0]', false)}"
                id='received_at'
                placeholder='Receivement Date'
                >
            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.received_at[0]', false) }}</div>
        </div>

        <div class="form-group">
            <label for="vendor_id"> Vendor: </label>
            <multiselect
                :disabled="picked_items.length > 0"
                placeholder="Vendor"
                :allow-empty="false"
                selectLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="m_vendors"
                v-model="vendor"
                :preselect-first="true"
            ></multiselect>
            <div v-if="get(this.error_data, 'errors.vendor_id[0]', false)" class='text-danger'>
                {{ get(this.error_data, 'errors.vendor_id[0]', false) }}
            </div>
        </div>

        <div class="form-group">
            <label> Item to Add: </label>
            <multiselect
                placeholder="Item"
                :allow-empty="false"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="item_options"
                v-model="selected_item"
                :preselect-first="true"
            ></multiselect>
        </div>

        <div class="form-group">
            <label> Item List: </label>
            <table v-if="picked_items.length > 0" class="table table-sm table-striped table-bordered">
                <thead class="thead thead-dark">
                    <tr>
                        <th> Item </th>
                        <th> Unit </th>
                        <th> Quantity </th>
                        <th class="text-center"> Controls </th>
                    </tr>
                </thead>

                <tbody>
                    <tr :key="i" v-for="(picked_item, i) in picked_items">
                        <td>
                            {{ picked_item.name }}
                        </td>
                        <td> {{ picked_item.unit }} </td>
                        <td>
                            <input
                                v-model.number='picked_item.quantity'
                                class='form-control'
                                :class="{'is-invalid': get(error_data, ['errors', `items.${i}.quantity`, 0], false)}"
                                type='number'
                                id='picked_item.quantity'
                                placeholder='Quantity'>
                            <div class='invalid-feedback'>
                                 {{ get(error_data, ['errors', `items.${i}.quantity`, 0], false) }}
                            </div>
                        </td>
                        <td class="text-center">
                            <button
                                @click="picked_item.picked = false"
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
                You haven't picked any item
            </div>
        </div>

        <div class="form-group d-flex justify-content-end">
            <button class="btn btn-primary">
                Store Delivery Order
            </button>
        </div>
    </form>
</template>

<script>

import { get } from 'lodash'
import { Multiselect } from 'vue-multiselect'

export default {
    components: { Multiselect },

    props: [
        "submit_url",
        "redirect_url",
        "delivery_order",
        "vendors",
        "storages",
        "users",
    ],

    data() {
        return {
            m_vendors: this.vendors.map(vendor => {
                return {
                    ...vendor,
                    items: vendor.items.map(item => {
                        return {
                            ...item,
                            picked: false,
                            quantity: 0,
                        }
                    })
                }
            }),

            receiver: null,
            storage: null,
            vendor: null,
            received_at: null,
            selected_item: null,
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
        selected_item(item) {
            if (item !== null) {
                item.picked = true
                this.selected_item = null
            }
        },
    },

    computed: {
        form_data() {
            return {
                receiver_id: this.receiver ? this.receiver.id : null,
                storage_id: this.storage ? this.storage.id : null,
                vendor_id: this.vendor ? this.vendor.id : null,
                received_at: this.received_at,
                items: this.picked_items.map(picked_items => { return {
                    item_id: picked_items.id,
                    quantity: picked_items.quantity,
                }})
            }
        },

        item_options() {
            if (this.vendor === null) {
                return []
            }
            else {
                return this.vendor.items.filter(item => !item.picked)
            }
        },

        picked_items() {
            return this.m_vendors.reduce((prev, curr) => {
                return [...prev, ...curr.items.filter(item => item.picked)]
            }, [])
        }
    }
}
</script>
