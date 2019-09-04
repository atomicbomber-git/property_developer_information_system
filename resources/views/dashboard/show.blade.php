@extends('shared.layout')

@section('title', 'Dashboard')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-cog"> </i>
                Dashboard
            </h1>

            <hr class="mt-2 mb-2">

            <div class="card-text mt-5 row">
                <div class="col-md-3">
                    <a href="{{ route('vendor.index') }}" class="mb-3 text-left btn btn-info btn-lg d-block">
                        <i class="fa fa-shopping-cart"></i>
                        Vendors
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('category.index') }}" class="mb-3 text-left btn btn-info btn-lg d-block">
                        <i class="fa fa-folder"></i>
                        Categories
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('item.index') }}" class="mb-3 text-left btn btn-info btn-lg d-block">
                        <i class="fa fa-cubes"></i>
                        Items
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('user.index') }}" class="mb-3 text-left btn btn-info btn-lg d-block">
                        <i class="fa fa-users"></i>
                        Users
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('storage.index') }}" class="mb-3 text-left btn btn-info btn-lg d-block">
                        <i class="fa fa-truck"></i>
                        Storages
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('delivery-order.index') }}" class="mb-3 text-left btn btn-info btn-lg d-block">
                        <i class="fa fa-credit-card"></i>
                        Delivery Orders
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('invoice.index') }}" class="mb-3 text-left btn btn-info btn-lg d-block">
                        <i class="fa fa-usd"></i>
                        Invoices
                    </a>
                </div>
                <div class="col-md-3">
                    <a href="{{ route('giro.index') }}" class="mb-3 text-left btn btn-info btn-lg d-block">
                        <i class="fa fa-money"></i>
                        Giros
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
