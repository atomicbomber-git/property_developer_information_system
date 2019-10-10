@extends('shared.layout')

@section('title', 'Create New Delivery Order')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('internal-delivery-order.index') }}"> Delivery Order (Internal) </a> </li>
            <li class="breadcrumb-item active"> Create Delivery Order </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Create Delivery Order
            </h1>

            <hr class="mt-2 mb-2">

            <div id="app">
                <internal-delivery-order-create
                    submit_url='{{ route('delivery-order.store') }}'
                    redirect_url='{{ route('delivery-order.index') }}'
                    :storages='{{ json_encode($storages) }}'
                    >
                </internal-delivery-order-create>
            </div>
        </div>
    </div>
</div>
@endsection
