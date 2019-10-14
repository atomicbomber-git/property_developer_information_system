<form action='{{ route('internal-delivery-order.delete', $delivery_order) }}' method='POST' class='d-inline-block form-delete'>
    @csrf
    <button
        @cannot("delete", $delivery_order) disabled  @endcannot
        type='submit'
        class='btn btn-danger btn-sm'>
        <i class='fa fa-trash'></i>
    </button>

    <a
        href="{{ route('internal-delivery-order.show', $delivery_order) }}"
        class="btn btn-sm btn-dark"
        >
        <i class="fa fa-list-alt"></i>
    </a>
</form>
