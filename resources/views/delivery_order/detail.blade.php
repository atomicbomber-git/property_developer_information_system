@extends('shared.layout')

@section('title', "Delivery Order Detail $delivery_order->id")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('delivery-order.index') }}"> Delivery Order (From Vendor) </a> </li>
            <li class="breadcrumb-item active"> {{ $delivery_order->id }} </li>
        </ol>
    </nav>

    @include('shared.message-success')

    <div class="card mb-3" style="max-width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Add Item ke Delivery Order
            </h1>

            <hr class="mt-2 mb-2">

            <form action="{{ route('delivery-order.create_item', $delivery_order) }}" method="POST">
                @csrf

                <div class='form-group'>
                    <label for='item_id'> Item: </label>
                    <select name='item_id' id='item_id' class='form-control'>
                        @foreach($delivery_order->source->items as $item)
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
                        id='quantity' name='quantity' type='number' step="0.001"
                        value='{{ old('quantity') }}'
                        class='form-control {{ !$errors->has('quantity') ?: 'is-invalid' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('quantity') }}
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-primary btn-sm">
                        Add Item
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-credit-card"></i>
                Detail Delivery Order
                <span class="badge badge-dark">
                    From {{ $delivery_order->source->name }} to {{ $delivery_order->target->name }}
                </span>
            </h1>

            <hr class="mt-2 mb-2">

            <table class="table table-sm table-striped">
                <thead class="thead thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Item </th>
                        <th> Quantity </th>
                        <th> Unit </th>
                        <th> Control </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($delivery_order->delivery_order_items as $delivery_order_item)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $delivery_order_item->item->name }} </td>
                        <td>
                            <input
                                form="form-update"
                                step="0.001"
                                value="{{ old("quantities.$delivery_order_item->id", $delivery_order_item->quantity) }}"
                                class="form-control form-control-sm {{ $errors->first("quantities.$delivery_order_item->id", 'is-invalid') }}"
                                name="quantities[{{ $delivery_order_item->id }}]"
                                type="number">

                            <div class='invalid-feedback'>
                                {{ $errors->first("quantities.$delivery_order_item->id") }}
                            </div>
                        </td>
                        <td> {{ $delivery_order_item->item->unit }} </td>

                        <td>
                            <form action="{{ route('delivery-order.delete_item', [$delivery_order, $delivery_order_item]) }}" method="POST">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <form method="POST" id="form-update" action="{{ route('delivery-order.update_items', $delivery_order) }}">
                @csrf
            </form>

            <div class="text-right mt-4">
                <button form="form-update" type="submit" class="btn btn-sm btn-primary">
                    Update Quantity
                    <i class="fa fa-check"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
