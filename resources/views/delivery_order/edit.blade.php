@extends('shared.layout')

@section('title', 'Edit Delivery Order')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('delivery-order.index') }}"> Delivery Order (From Vendor) </a> </li>
            <li class="breadcrumb-item active"> Edit Delivery Order (From Vendor) </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 35rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Edit Delivery Order
            </h1>

            <hr class="mt-2 mb-2">

            <div id="app">
                <delivery-order-edit
                    submit_url='{{ route('delivery-order.update', $delivery_order) }}'
                    redirect_url='{{ route('delivery-order.edit', $delivery_order) }}'
                    :delivery_order='{{ json_encode($delivery_order) }}'
                    :storages='{{ json_encode($storages) }}'
                    :vendors='{{ json_encode($vendors) }}'
                    :users='{{ json_encode($users) }}'
                >
                </delivery-order-edit>
            </div>
        </div>
    </div>
</div>
@endsection
