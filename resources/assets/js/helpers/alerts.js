import Swal from 'sweetalert2'

export function confirmationModal() {
    return Swal.fire({
        title: "Confirmation",
        text: "Are you sure you want to do this action?",
        type: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
    })
}
