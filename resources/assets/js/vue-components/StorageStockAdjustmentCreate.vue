<template>
    <form @submit.prevent="onFormSubmit">
        <h4>
            <i class="fa fa-list-alt"></i>
            New Items
        </h4>


        <hr>

        <h4>
            <i class="fa fa-list-alt"></i>
            Existing Items
        </h4>

        <table class="table table-sm table-striped">
            <thead class="thead thead-dark">
                <tr>
                    <th> Item </th>
                    <th> Quantity </th>
                    <th> Unit </th>
                    <th> Origin </th>
                </tr>
            </thead>

            <tbody>
                <tr
                    v-for="stock in m_stocks"
                    :key="stock.id"
                    >

                    <td> {{ stock.item.name }} </td>
                    <td>
                        <div class='form-group'>
                            <input
                                v-model.number='stock.quantity'
                                class='form-control form-control-sm'
                                :class="{'is-invalid': get(this.error_data, 'errors.quantity[0]', false)}"
                                type='number'
                                step='any'
                                id='quantity'
                                placeholder='Quantity'>
                            <div class='invalid-feedback'>
                                 {{ get(this.error_data, 'errors.quantity[0]', false) }}
                            </div>
                        </div>
                    </td>
                    <td> {{ stock.item.unit }} </td>
                    <td>
                        {{ getStockOriginName(stock) }}
                        <br>
                        {{ getStockOriginDate(stock) }}
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="d-flex justify-content-end">
            <button class="btn btn-primary">
                Submit
            </button>
        </div>
    </form>
</template>

<script>

import { dateFormat } from '../helpers/datetime'
import { numberNormalize } from '../helpers/number'
import { get } from 'lodash'
import { confirmationModal } from '../helpers/alerts'

export default {
    props: [
        "submit_url",
        "redirect_url",
        "storage",
        "items",
    ],

    data() {
        return {
            m_stocks: this.storage
                .stocks
                .map(stock => ({
                    ...stock,
                    quantity: numberNormalize(stock.quantity),
                }))
        }
    },

    computed: {
        form_data() {
            return {
                old_stocks: this.m_stocks.map(stock => ({
                    id: stock.id,
                    quantity: stock.quantity,
                }))
            }
        }
    },

    methods: {
        dateFormat,
        numberNormalize,
        get,

        getStockOriginName(stock) {
            if (stock.origin_type === "DELIVERY_ORDER_ITEM") {
                return `${stock.origin.delivery_order.source.name}`
            }

            return null
        },

        getStockOriginDate(stock) {
            if (stock.origin_type === "DELIVERY_ORDER_ITEM") {
                return `${dateFormat(stock.origin.delivery_order.received_at)}`
            }

            return null
        },

        onFormSubmit() {
            confirmationModal()
                .then(will_submit => {
                    if (!will_submit) {
                        return
                    }

                    this.submitForm()
                })
        },

        submitForm() {
            axios.post(this.submit_url, this.form_data)
               .then(response => {
                    window.location.replace(this.redirect_url)
               })
               .catch(error => {
                   this.error_data = error.response.data
               })
        }
    }
}
</script>
