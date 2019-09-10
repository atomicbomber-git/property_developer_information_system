import numeral from 'numeral'

export function numberFormat(value) {
    return numeral(value).format("0,0.[00]")
}

function emptySymbol() {
    return "-"
}

export function numberDataTableRenderer(data, type, row) {
    return data
}

export function currencyDataTableRenderer(data, type, row) {
    if (type !== 'display') {
        return data ? data.price : null
    }

    return data ?
        numberFormat(data.price) :
        emptySymbol()
}


