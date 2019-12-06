<template>
    <form @submit.prevent="onFormSubmit">
        <table class="table table-striped table-inverse table-sm table-bordered">
            <thead class="thead thead-dark">
                <tr>
                    <th> # </th>
                    <th> Item </th>
                    <th class="text-right"> Quantity </th>
                    <th> Unit </th>
                    <th class="text-right"> Price (Rp.) </th>
                    <th class="text-right"> Subtotal (Rp.) </th>
                </tr>
            </thead>
            <tbody>
                <DeliveryOrderPriceEditLine
                    v-for="(wrapped_delivery_order_item, index) of m_delivery_order.wrapped_delivery_order_items"
                    :key="wrapped_delivery_order_item.delivery_order_item.id"
                    v-model="wrapped_delivery_order_item.delivery_order_item"
                    :index="index"
                    >
                </DeliveryOrderPriceEditLine>
            </tbody>
            <tfoot>
                <tr>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td> </td>
                    <td class="text-right">
                        {{ numberFormat(total_price) }}
                    </td>
                </tr>
            </tfoot>
        </table>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">
                Submit
                <i class="fa fa-check"></i>
            </button>
        </div>
    </form>
</template>

<script>

import { numberFormat } from "../helpers/number"
import { confirmationModal, errorModal, loadingModal } from "../helpers/modals"
import DeliveryOrderPriceEditLine from "./DeliveryOrderPriceEditLine"
import Swal from 'sweetalert2'

export default {
    props: {
        submit_url: String,
        redirect_url: String,
        delivery_order: Object,
    },

    components: {
        DeliveryOrderPriceEditLine,
    },

    data() {
        return {
            m_delivery_order: {
                ...this.delivery_order,
                wrapped_delivery_order_items: this.delivery_order
                    .delivery_order_items
                    .map(delivery_order_item => ({
                        delivery_order_item: {
                            ...delivery_order_item,
                        }
                    }))
            }
        }
    },

    methods: {
        numberFormat,

        onFormSubmit() {
            confirmationModal()
                .then(ok => {
                    if (!ok) {
                        return
                    }

                    loadingModal()

                    axios.post(this.submit_url, this.form_data)
                       .then(response => {
                            Swal.hideLoading()
                            window.location.replace(this.redirect_url)
                       })
                       .catch(error => {
                           this.error_data = error.response.data
                           errorModal()
                       })
                })
        },
    },

    computed: {
        total_price() {
            return this.m_delivery_order
                .wrapped_delivery_order_items
                .map(wrapped_delivery_order_items => wrapped_delivery_order_items.delivery_order_item)
                .reduce((curr, next) => {
                    return curr + ((next.price || 0) * next.quantity)
                }, 0)
        },

        form_data() {
            return {
                delivery_order_items: this.m_delivery_order
                    .wrapped_delivery_order_items
                    .map(({ delivery_order_item }) => delivery_order_item)
                    .map(({ id, price }) => ({ id, price }))
            }
        }
    },
}
</script>
