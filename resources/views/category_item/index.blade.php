@extends('shared.layout')

@section('title', "Items In Category '$category->name'")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('category.index') }}"> Category </a> </li>
            <li class="breadcrumb-item active"> Items in '{{ $category->name }}' </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-list"></i>
                Item
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('category-item.create', $category) }}" class="btn btn-secondary btn-sm">
                    Tambahkan Item Baru
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Item </th>
                            <th> Unit </th>
                            <th style="width: 7rem"> Vendor </th>
                            <th class="text-right pr-5"> Latest Price (Rp.) </th>
                            <th style="width: 12rem"> Note </th>
                            <th> Control </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td> {{ $items->firstItem() + $loop->index }}. </td>
                            <td> {{ $item->name }} </td>
                            <td> {{ $item->unit }} </td>
                            <td> {{ $item->vendor->name }} </td>
                            <td class="text-right pr-5">
                                @if($latest_prices->get($item->id))
                                    @convert_money($latest_prices->get($item->id))
                                @else
                                    -
                                @endif
                            </td>
                            <td>
                                {{ $item->note }}
                            </td>
                            <td>
                                <a href="{{ route('category-item.price_history', [$category, $item]) }}" class="btn btn-dark btn-sm mr-2">
                                    Price History
                                    <i class="fa fa-line-chart"></i>
                                </a>

                                <a href="{{ route('category-item.update', [$category, $item]) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                @if ($item->delivery_order_items_count == 0)

                                <form method="POST" class="d-inline-block" action="{{ route('category-item.delete', [$category, $item]) }}">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                @else

                                <button class="btn btn-danger btn-sm disabled" data-toggle="tooltip" title="Data ini tidak dapat dihapus karena masih terdapat item terkait dengan data ini.">
                                    <i class="fa fa-trash"></i>
                                </button>

                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="text-align: center">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    $(document).ready(() => {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection
