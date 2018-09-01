@extends('shared.layout')

@section('title', 'Create New Delivery Order')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('delivery_order.index') }}"> Delivery Order (From Vendor) </a> </li>
            <li class="breadcrumb-item active"> Tambahkan Delivery Order Baru </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 30rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Tambahkan Delivery Order Baru
            </h1>

            <hr class="mt-2 mb-2">

            <div id="example">
                <Example> </Example>
            </div>
        </div>
    </div>
</div>
@endsection