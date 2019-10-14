<form action='{{ route('delivery-order.delete', $delivery_order) }}' method='POST' class='d-inline-block form-delete'>
    @csrf
    <button
        @cannot("delete", $delivery_order) disabled  @endcannot
        type='submit'
        class='btn btn-danger btn-sm'>
        <i class='fa fa-trash'></i>
    </button>

    <a
        class="btn btn-dark btn-sm"
        href="{{ route('internal-delivery-order.show', $delivery_order) }}">
        <i class="fa fa-show"></i>
    </a>
</form>
