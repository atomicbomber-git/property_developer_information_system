@extends('shared.layout')

@section('title', "DeliveryOrder Detail $delivery_order->id")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('delivery-order.index') }}"> DeliveryOrder </a> </li>
            <li class="breadcrumb-item active"> <a href="{{ route('delivery-order.detail', $delivery_order) }}"> {{ $delivery_order->id }} </a> </li>
        </ol>
    </nav>

    @include('shared.message-success')

    <div class="row">
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-body">
                    <h1 class="h5 card-title">
                        <i class="fa fa-money"></i>
                        DeliveryOrder {{ $delivery_order->id }}
                    </h1>

                    <hr class="mt-2 mb-2">

                    <div class="mb-2">
                        <div class="d-block"> Nama Pemesan: </div>
                        <strong> {{ $delivery_order->creator->name }} </strong>
                    </div>

                    <div class="mb-2">
                        <div class="d-block"> Nama Vendor: </div>
                        <strong> {{ $delivery_order->vendor->name }} </strong>
                    </div>

                    <div class="mb-2">
                        <div class="d-block"> Tanggal Pemesanan: </div>
                        <strong> {{ $delivery_order->created_at->format('d-m-Y') }} </strong>
                    </div>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="row mb-4">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h1 class="h5 card-title">
                                <i class="fa fa-plus"></i>
                                Add Item
                            </h1>

                            <hr class="mt-2 mb-2">

                            <form method="POST" action="{{ route('allocation.create', $delivery_order) }}">
                                @csrf
                                <div class='form-group'>
                                    <label for='item_id'> Item: </label>
                                    <select name='item_id' id='item_id' class='form-control'>
                                        @foreach($delivery_order->vendor->items as $item)
                                        <option {{ old('item_id') !== $item->id ?: 'selected' }} value='{{ $item->id }}'> {{ $item->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class='invalid-feedback'>
                                        {{ $errors->first('item_id') }}
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label for='quantity'> Quantity: </label>

                                    <input
                                        min="1"
                                        id='quantity' name='quantity' type='number'
                                        value='{{ old('quantity') }}'
                                        class='form-control {{ !$errors->has('quantity') ?: 'is-invalid' }}'>

                                    <div class='invalid-feedback'>
                                        {{ $errors->first('quantity') }}
                                    </div>
                                </div>

                                <div class='form-group'>
                                    <label for='storage_id'> Storage: </label>
                                    <select name='storage_id' id='storage_id' class='form-control'>
                                        @foreach($storages as $storage)
                                        <option {{ old('storage_id') !== $storage->id ?: 'selected' }} value='{{ $storage->id }}'> {{ $storage->name }} </option>
                                        @endforeach
                                    </select>
                                    <div class='invalid-feedback'>
                                        {{ $errors->first('storage_id') }}
                                    </div>
                                </div>

                                <div class="text-right mt-3">
                                    <button class="btn btn-primary btn-sm">
                                        Add
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h5 card-title">
                            <i class="fa fa-list-alt"></i>
                            Daftar Item Pesanan
                        </h1>

                        <hr class="mt-2 mb-2">

                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead class="thead thead-dark">
                                    <tr>
                                        <th> # </th>
                                        <th> Item </th>
                                        <th> Qty. </th>
                                        <th> Satuan </th>
                                        <th> Harga per Satuan </th>
                                        <th class="text-center"> <i class="fa fa-wrench"></i> </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($delivery_order->invoice_items as $invoice_item)
                                    <tr class="font-weight-bold table-active mb-3">
                                        <td> {{ $loop->iteration }}. </td>
                                        <td class="text-primary"> {{ $invoice_item->item->name }} </td>
                                        <td> {{ $invoice_item->total_quantity }} </td>
                                        <td> {{ $invoice_item->item->unit }} </td>
                                        <td> {{ $invoice_item->price ?? '-' }} </td>
                                        <td class="text-center">
                                            <button class="btn btn-toggle-subitem btn-sm" data-delivery_order-item-id="{{ $invoice_item->id }}">
                                                <i class="fa fa-chevron-up"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <tr class="d-none" data-delivery_order-item-id="{{ $invoice_item->id }}">
                                        <td class="pt-2"></td>
                                        <td class="pt-2"></td>
                                        <td class="pt-2"></td>
                                        <td class="pt-2"></td>
                                        <td class="pt-2"></td>
                                        <td class="pt-2"></td>
                                    </tr>

                                    @foreach ($invoice_item->allocations as $allocation)
                                    <tr class="d-none" data-delivery_order-item-id="{{ $invoice_item->id }}">
                                        <td class="border-top-0 pt-1 {{ $loop->last ? 'pb-4' : 'pb-1' }}"> </td>
                                        <td class="border-top-0 pt-1 align-middle {{ $loop->last ? 'pb-4' : 'pb-1' }}">
                                            <form method="POST" class="d-inline-block" action="{{ route('allocation.delete', [$delivery_order, $allocation]) }}">
                                                @csrf
                                                <button class="btn btn-outline-danger btn-sm mr-2">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                            {{ $allocation->storage->name }}
                                        </td>
                                        <td class="border-top-0 pt-1 {{ $loop->last ? 'pb-4' : 'pb-1' }}"> {{ $allocation->quantity }} </td>
                                        <td class="border-top-0 pt-1 {{ $loop->last ? 'pb-4' : 'pb-1' }}"> </td>
                                        <td class="border-top-0 pt-1 {{ $loop->last ? 'pb-4' : 'pb-1' }}"> </td>
                                        <td class="border-top-0 pt-1 {{ $loop->last ? 'pb-4' : 'pb-1' }}"> </td>
                                    </tr>
                                    @endforeach

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    const toggle_active_class = 'fa-chevron-down';
    const toggle_inactive_class = 'fa-chevron-up';

    $(document).ready(() => {
        $('button.btn-toggle-subitem[data-delivery_order-item-id]').each((i, button) => {
            let id = $(button).data('delivery_order-item-id');
            let icon = $(button).find('i');

            $(button).click(() => {
                console.log(id);
                $(`tr[data-delivery_order-item-id=${id}]`)
                    .toggleClass('d-none');

                icon.toggleClass(toggle_active_class);
                icon.toggleClass(toggle_inactive_class);
            })
        })
    });
</script>
@endsection
