import moment from 'moment'

export function toHTMLInputDateFormat(value) {
    return moment(value).format("Y-MM-DD")
}
