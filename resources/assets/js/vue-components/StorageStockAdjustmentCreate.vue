<template>
    <form @submit.prevent="onFormSubmit">
        <div>
            <h4>
                <i class="fa fa-list-alt"></i>
                New Items
            </h4>

            <div class="form-group">
                <label> Item to Add: </label>

                <multiselect
                    placeholder="Item"
                    selectLabel=""
                    selectedLabel=""
                    deselectLabel=""
                    track-by="id"
                    label="name"
                    :options="unpicked_items"
                    v-model="m_item"
                ></multiselect>
            </div>

            <div class="form-group">
                <table class="table table-sm table-striped">
                    <thead class="thead thead-dark">
                        <tr>
                            <th> Item </th>
                            <th> Quantity </th>
                            <th> Unit </th>
                            <th> Value </th>
                            <th class="text-center"> Controls </th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="item in picked_items"
                            :key="item.id"
                            >
                            <td> {{ item.name }} </td>
                            <td>
                                <input
                                    v-model.number='item.quantity'
                                    class='form-control form-control-sm'
                                    :class="{'is-invalid': get(this.error_data, 'errors.quantity[0]', false)}"
                                    type='number'
                                    id='quantity'
                                    placeholder='Quantity'>
                                <div class='invalid-feedback'>
                                        {{ get(this.error_data, 'errors.quantity[0]', false) }}
                                </div>
                            </td>
                            <td> {{ item.unit }} </td>
                            <td>
                                <input
                                    v-model.number='item.value'
                                    class='form-control form-control-sm'
                                    :class="{'is-invalid': get(this.error_data, 'errors.value[0]', false)}"
                                    type='number'
                                    id='value'
                                    placeholder='Value'>
                                <div class='invalid-feedback'>
                                    {{ get(this.error_data, 'errors.value[0]', false) }}
                                </div>
                            </td>
                            <td class="text-center">
                                <button
                                    @click="item.picked = false; item.quantity = 0; item.value = 0"
                                    class="btn btn-sm btn-danger"
                                    type="button">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <hr class="my-5">

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
                    <th> Value </th>
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
                    <td> {{ currencyFormat(stock.value) }} </td>
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
import { numberNormalize, currencyFormat } from '../helpers/number'
import { get } from 'lodash'
import { confirmationModal } from '../helpers/alerts'
import Multiselect from 'vue-multiselect'

export default {
    props: [
        "submit_url",
        "redirect_url",
        "storage",
        "items",
    ],

    components: { Multiselect },

    data() {
        return {
            m_stocks: this.storage
                .stocks
                .map(stock => ({
                    ...stock,
                    quantity: numberNormalize(stock.quantity),
                })),

            m_items: this.items
                .map(item => ({
                    ...item,
                    quantity: 0,
                    value: null,
                    picked: false,
                })),

            m_item: null,
        }
    },

    watch: {
        m_item(picked_item) {
            if (picked_item === null) {
                return
            }

            picked_item.quantity = 0
            picked_item.picked = true
            picked_item = null
        }
    },

    computed: {
        form_data() {
            return {
                new_stocks: this.picked_items.map(item => ({
                    item_id: item.id,
                    quantity: item.quantity,
                    value: item.value,
                })),

                old_stocks: this.m_stocks.map(stock => ({
                    id: stock.id,
                    quantity: stock.quantity,
                }))
            }
        },

        unpicked_items() {
            return this.m_items.filter(item => !item.picked)
        },

        picked_items() {
            return this.m_items.filter(item => item.picked)
        },
    },

    methods: {
        dateFormat,
        numberNormalize,
        currencyFormat,
        get,

        getStockOriginName(stock) {
            if (stock.origin_type === "DELIVERY_ORDER_ITEM") {
                return get(
                    stock,
                    "origin.delivery_order.source.name",
                )
            }
            else if (stock.origin_type === "STOCK_ADJUSTMENT") {
                return "STOCK ADJUSTMENT"
            }

            return null
        },

        getStockOriginDate(stock) {
            if (stock.origin_type === "DELIVERY_ORDER_ITEM") {
                let received_at = get(stock, "origin.delivery_order.received_at", null)

                if (received_at) {
                    return dateFormat(received_at)
                }

                return null;
            }
            else if (stock.origin_type === "STOCK_ADJUSTMENT") {
                return `${dateFormat(stock.origin.created_at)}`
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
