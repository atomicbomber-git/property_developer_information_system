<div>
    <a href="{{ route('item-price-history.index', $item) }}" class="btn btn-dark btn-sm">
        Price History
        <i class="fa fa-line-chart"></i>
    </a>

    <a href="{{ route('item.edit', $item) }}" class="btn btn-dark btn-sm">
        <i class="fa fa-pencil"></i>
    </a>

    <form action='{{ route('item.delete', $item) }}' method='POST' class='d-inline-block form-delete'>
        @csrf
        <button
            @cannot("delete", $item) disabled @endcan
            type='submit'
            class='btn btn-danger btn-sm'>
            <i class='fa fa-trash'></i>
        </button>
    </form>
</div>
