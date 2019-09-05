@extends('shared.layout')

@section('title', "Update Delivery Order $delivery_order->id")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('delivery-order.index') }}"> Delivery Order </a> </li>
            <li class="breadcrumb-item active"> Update Delivery Order {{ $delivery_order->id }} </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 35rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Add Delivery Order
            </h1>

            <hr class="mt-2 mb-2">

            <div id="app">
                <delivery-order-create
                    submit_url='{{ route('delivery-order.store') }}'
                    redirect_url='{{ route('delivery-order.index') }}'
                    :storages='{{ json_encode($storages) }}'
                    :vendors='{{ json_encode($vendors) }}'
                    :users='{{ json_encode($users) }}'
                >
                </delivery-order-create>
            </div>
        </div>
    </div>
</div>
@endsection
