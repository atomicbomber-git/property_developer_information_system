<template>
    <tr>
        <td> {{ index + 1 }} </td>
        <td> {{ m_value.item.name }} </td>
        <td class="text-right">
            {{ numberFormat(m_value.quantity) }}
        </td>
        <td> {{ m_value.item.unit }} </td>
        <td>
            <vue-cleave
                class="form-control form-control-sm text-right"
                v-model.number="m_value.price"
                :options="{
                   numeral: true,
                   numeralDecimalScale: 4,
                }">
            </vue-cleave>

            <div class="text-right">
                <button
                    type="button"
                    @click="m_value.price = m_value.latest_price"
                    class="btn btn-sm btn-dark mt-1"
                    >
                    Latest Price: {{ numberFormat(m_value.latest_price) }}
                </button>
            </div>
        </td>
        <td class="text-right">
            {{ currencyFormat(m_value.quantity * m_value.price) }}
        </td>
    </tr>
</template>

<script>

import { numberFormat, currencyFormat } from "../helpers/number"
import VueCleave from "vue-cleave-component"

export default {
    props: {
        value: Object,
        index: Number,
    },

    components: {
        VueCleave
    },

    data() {
        return {
            m_value: { ...this.value },
        }
    },

    methods: {
        numberFormat,
        currencyFormat,
    },

    watch: {
        "m_value.price": function () {
            this.$emit("input", this.m_value)
        }
    }
}
</script>

