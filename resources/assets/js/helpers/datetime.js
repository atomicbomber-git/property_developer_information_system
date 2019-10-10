import moment from 'moment'

export function toHTMLInputDateFormat(value) {
    return moment(value).format("Y-MM-DD")
}

export function dateFormat(value) {
    return moment(value).format("DD-MM-Y")
}
