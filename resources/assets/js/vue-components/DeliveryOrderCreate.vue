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
            <label for='receivement_date'> Receivement Date: </label>
            <input
                v-model='receivement_date'
                class='form-control'
                :class="{'is-invalid': get(this.error_data, 'errors.receivement_date[0]', false)}"
                type='text' id='receivement_date' placeholder='Receivement Date'>
            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.receivement_date[0]', false) }}</div>
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
            <table class="table table-sm table-striped">
                <thead class="thead thead-dark">
                    <tr>
                        <th> Item </th>
                        <th class="text-center"> Controls </th>
                    </tr>
                </thead>

                <tbody>
                    <tr :key="picked_item.id" v-for="picked_item in picked_items">
                        <td> {{ picked_item.name }} </td>
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
                        }
                    })
                }
            }),

            receiver: null,
            storage: null,
            vendor: null,
            receivement_date: null,
            selected_item: null,
            error_data: null,
        }
    },

    methods: {
        get,

        onFormSubmit() {

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
