function attachDeleteFormEventHandlers() {
    $("form.form-delete")
        .each(function(index, elem) {
            let form = $(elem)

            $(elem).submit(function (e) {
                e.preventDefault()

                Swal.fire({
                    title: "{{ __('modal.confirm.delete.title') }}",
                    text: "{{ __('modal.confirm.delete.text') }}",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonText: "{{ __('modal.confirm.delete.button-yes') }}",
                    cancelButtonText: "{{ __('modal.confirm.delete.button-no') }}",
                })
                .then((result) => {
                    if (result.value) {
                        Swal.fire(
                            "{{ __('modal.notification.delete.success.title') }}",
                            "{{ __('modal.notification.delete.success.text') }}",
                            "success",
                        )
                        .then(result => {
                            form.off("submit").submit()
                        })
                    }
                })
            })
        })
}
