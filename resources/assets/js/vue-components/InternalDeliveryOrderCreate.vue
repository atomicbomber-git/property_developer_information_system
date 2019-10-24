<template>
    <form @submit.prevent="onFormSubmit">
        <div class='form-group'>
            <label for='source_id'> Source: </label>
            <multiselect
                placeholder="Source"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="source_storages"
                v-model="source"
            ></multiselect>
            <div class='invalid-feedback'>
                {{ get(this.error_data, 'errors.source_id[0]', false) }}
            </div>
        </div>

        <div class='form-group'>
            <label for='target_id'> Target: </label>
            <multiselect
                placeholder="Target"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="target_storages"
                v-model="target"
            ></multiselect>
            <div class='invalid-feedback'>
                 {{ get(this.error_data, 'errors.target_id[0]', false) }}
            </div>
        </div>

        <div class="form-group">
            <label for="receiver_id"> Sender: </label>
            <multiselect
                placeholder="Sender"
                :allow-empty="false"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="users"
                v-model="sender"
                :preselect-first="true"
            ></multiselect>
        </div>

        <div class='form-group'>
            <label for='sent_at'> Sending Date: </label>
            <input
                type="date"
                v-model='sent_at'
                class='form-control'
                :class="{'is-invalid': get(this.error_data, 'errors.sent_at[0]', false)}"
                id='sent_at'
                placeholder='Receivement Date'
                >
            <div class='invalid-feedback'>{{ get(this.error_data, 'errors.sent_at[0]', false) }}</div>
        </div>

        <div class="form-group">
            <label for="receiver_id"> Driver: </label>
            <multiselect
                placeholder="Driver"
                :allow-empty="false"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                label="name"
                :options="users"
                v-model="driver"
                :preselect-first="true"
            ></multiselect>
        </div>

        <div class='form-group'>
            <label for='stock'> Stock to Add: </label>
            <multiselect
                placeholder="Stock"
                :allow-empty="false"
                selectLabel=""
                selectedLabel=""
                deselectLabel=""
                track-by="id"
                :options="unpicked_stocks"
                v-model="stock"
                :preselect-first="true"
                :custom-label="stock => `${stock.item.name} ${stockOriginName(stock)} ${stockOriginDate(stock)}`"
            >
                <template slot="singleLabel" slot-scope="props">
                    <span class="option__desc"><span class="option__title">{{ props.option.item.name }}</span></span>
                </template>
                <template slot="option" slot-scope="props">
                    <div class="option__desc mb-2">
                        <div class="font-weight-bold">
                            <span class="option__title">
                                {{ props.option.item.name }}
                            </span>

                            <span class="text-danger">
                                {{ numberFormat(props.option.quantity) }}
                            </span>

                            <span>
                                {{ props.option.item.unit }}
                            </span>
                        </div>
                        <div>
                            <span class="option__small">
                                {{ stockOriginName(props.option) }} {{ stockOriginDate(props.option) }}
                            </span>
                        </div>
                    </div>
                </template>
            </multiselect>

            <table class="table table-sm table-striped mt-4">
                <thead class="thead thead-dark">
                    <tr>
                        <th> Item </th>
                        <th> Source </th>
                        <th> Stock </th>
                        <th> Quantity </th>
                        <th> Unit </th>
                        <th> Controls </th>
                    </tr>
                </thead>

                <tbody>
                    <tr
                        v-for="stock in picked_stocks"
                        :key="stock.id"
                    >
                        <td> {{ stock.item.name }} </td>
                        <td> {{ stockLabel(stock) }} </td>
                        <td> {{ numberFormat(stock.quantity) }} </td>
                        <td>
                            <input
                                v-model.number='stock.picked_quantity'
                                class='form-control'
                                :class="{'is-invalid': get(this.error_data, 'errors.picked_quantity[0]', false)}"
                                type='number'
                                step="any"
                                id='picked_quantity'
                                placeholder='Quantity'>
                        </td>
                        <td> {{ stock.item.unit }} </td>
                        <td class="text-center">
                            <button
                                @click="stock.picked_quantity = 0; stock.picked = false"
                                class="btn btn-danger btn-sm"
                                type="button">
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>


            <div class='invalid-feedback'>
                 {{ get(this.error_data, 'errors.stock[0]', false) }}
            </div>
        </div>

        <div class="form-group d-flex justify-content-end">
            <button class="btn btn-primary">
                Add Delivery Order
                <i class="fa fa-plus"></i>
            </button>
        </div>
    </form>
</template>

<script>

import { get } from 'lodash'
import { dateFormat } from '../helpers/datetime'
import { numberFormat } from '../helpers/number'
import { Multiselect } from 'vue-multiselect'

export default {
    components: { Multiselect },

    props: [
        "submit_url",
        "redirect_url",
        "storages",
        "users",
    ],

    data() {
        return {
            m_storages: this.storages.map(storage => ({
                ...storage,
                stocks: storage.stocks.map(stock => ({
                    ...stock,
                    picked_quantity: 0,
                    picked: false,
                }))
            })),

            source: null,
            target: null,
            sender: null,
            driver: null,
            stock: null,
            sent_at: null,
            error_data: null,
        }
    },

    methods: {
        get,
        dateFormat,
        numberFormat,

        stockLabel(stock) {
            return `${this.stockOriginName(stock)} ${this.stockOriginDate(stock)}`
        },

        stockOriginName(stock) {
            if (stock.origin_type === "DELIVERY_ORDER_ITEM") {
                let name = get(stock, "origin.delivery_order.source.name", null)
                return name
            }
            else if (stock.origin_type === "STOCK_ADJUSTMENT") {
                return "STOCK ADJUSTMENT"
            }

            return null
        },

        stockOriginDate(stock) {
            if (stock.origin_type === "DELIVERY_ORDER_ITEM") {
                let sent_at = get(stock, "origin.delivery_order.sent_at", false)
                return sent_at ? dateFormat(sent_at) : null
            }
            else if (stock.origin_type === "STOCK_ADJUSTMENT") {
                let created_at = get(stock, "origin.created_at", false)
                return created_at ? dateFormat(created_at) : null
            }

            return null
        },

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
        stock(stock) {
            if (stock === null) {
                return
            }

            stock.picked = true
            stock.picked_quantity = 0
            stock = null
        }
    },

    computed: {
        form_data() {
            return {
                stocks: this.picked_stocks.map(stock => ({
                    id: stock.id,
                    quantity: stock.picked_quantity,
                })),

                sent_at: this.sent_at,
                source_id: this.source ? this.source.id : null,
                target_id: this.target ? this.target.id : null,
                driver_id: this.driver ? this.driver.id : null,
                sender_id: this.sender ? this.sender.id : null,
            }
        },

        source_storages() {
            return this.m_storages
                .filter(storage => {
                    return storage.id
                        != (this.target ? this.target.id : null)
                })
        },

        target_storages() {
            return this.m_storages
                .filter(storage => {
                    return storage.id
                        != (this.source ? this.source.id : null)
                })
        },

        unpicked_stocks() {
            if (this.source === null) {
                return []
            }

            return this.source
                .stocks
                .filter(stock => !stock.picked)
        },

        picked_stocks() {
            if (this.source === null) {
                return []
            }

            return this.source
                .stocks
                .filter(stock => stock.picked)
        }
    }
}
</script>
