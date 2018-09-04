@extends('shared.layout')

@section('title', "Update Item Prices in Delivery Order $delivery_order->id")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('delivery_order.index') }}"> Delivery Order </a> </li>
            <li class="breadcrumb-item active"> Update Prices in Delivery Order {{ $delivery_order->id }} </li>
        </ol>
    </nav>

    @include('shared.message-success')

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-usd"></i>
                Update Prices in Delivery Order {{ $delivery_order->id }}
            </h1>

            <hr class="mt-2 mb-2">

            <div id="update-delivery-order-prices-form">
                <UpdateDeliveryOrderPricesForm/>
            </div>

        </div>
    </div>
</div>
@endsection