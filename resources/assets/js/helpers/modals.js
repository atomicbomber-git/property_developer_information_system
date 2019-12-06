import Swal from "sweetalert2"

export function confirmationModal(
    title = 'Confirm Action',
    text = 'Are you sure you want to perform this action?'
) {
    return Swal.fire({
        title,
        text,
        icon: 'question',
        showCloseButton: true,
        showCancelButton: true,
    })
}

export function loadingModal() {
    Swal.showLoading()

    return Swal.fire(
        'Loading',
        'Please wait',
    )
}

export function errorModal(
    title = 'Error',
    text = 'There has been an error.'
) {
    Swal.hideLoading()

    return Swal.fire(
        title,
        text,
        'error'
    )
}