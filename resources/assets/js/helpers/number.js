import numeral from 'numeral'

function emptySymbol() {
    return "-"
}

export function numberFormat(value) {
    return numeral(value).format("0,0.[00]")
}

export function numberNormalize(value) {
    return numeral(value).format("0.[00]")
}

export function currencyFormat(value) {
    return value ?
        numeral(value).format("0,0.[00]") :
        emptySymbol()
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


