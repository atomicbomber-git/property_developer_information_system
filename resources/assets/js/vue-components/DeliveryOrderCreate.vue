<template>
    <p>
        Lorem ipsum dolor sit amet consectetur adipisicing elit. A libero fuga dolorem, numquam, asperiores dignissimos impedit, nostrum molestiae officiis sint incidunt ad dolor! Amet delectus ipsum suscipit tenetur, voluptatibus earum.
    </p>
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
