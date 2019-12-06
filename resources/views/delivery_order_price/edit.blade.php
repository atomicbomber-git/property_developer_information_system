@extends('shared.layout')

@section('title', "Update Item Prices in Delivery Order $delivery_order->id")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('delivery-order.index') }}"> Delivery Order </a> </li>
            <li class="breadcrumb-item active"> Update Prices in Delivery Order {{ $delivery_order->id }} </li>
        </ol>
    </nav>

    @include('shared.message-success')

    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h1 class="h5">
                        <i class="fa fa-usd"></i>
                        Update Prices in Delivery Order {{ $delivery_order->id }}
                    </h1>
                </div>
                <div class="col text-right">
                    <a href="{{ route('invoice.pay', $delivery_order->invoice_id) }}" class="btn btn-secondary btn-sm">
                        Go to Invoice Payment ({{ $delivery_order->invoice->number }} On {{ $delivery_order->invoice->received_at->format('d-m-Y') }}) <i class="fa fa-money"></i>
                    </a>
                </div>
            </div>

            <hr class="mt-2 mb-2">

            <div id="app">
                <delivery-order-price-edit
                    submit_url="{{ route('delivery-order-price.update', $delivery_order) }}"
                    redirect_url="{{ route('delivery-order-price.edit', $delivery_order) }}"
                    :delivery_order='{{ json_encode($delivery_order) }}'
                    >
                </delivery-order-price-edit>
            </div>
        </div>
    </div>
</div>
@endsection
