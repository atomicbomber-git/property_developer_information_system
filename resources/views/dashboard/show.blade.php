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

            <p class="card-text mt-5">
                <a href="{{ route('vendor.index') }}" class="my-1 mr-2 btn btn-info btn-lg">
                    <i class="fa fa-shopping-cart"></i>
                    Vendors
                </a>

                <a href="{{ route('category.index') }}" class="my-1 mr-2 btn btn-info btn-lg">
                    <i class="fa fa-folder"></i>
                    Categories and Items
                </a>

                <a href="{{ route('user.index') }}" class="my-1 mr-2 btn btn-info btn-lg">
                    <i class="fa fa-users"></i>
                    Users
                </a>

                <a href="{{ route('storage.index') }}" class="my-1 mr-2 btn btn-info btn-lg">
                    <i class="fa fa-truck"></i>
                    Storages
                </a>

                <a href="{{ route('delivery-order.index') }}" class="my-1 mr-2 btn btn-info btn-lg">
                    <i class="fa fa-credit-card"></i>
                    Delivery Orders (From Vendor)
                </a>

                <a href="{{ route('invoice.index') }}" class="my-1 mr-2 btn btn-info btn-lg">
                    <i class="fa fa-usd"></i>
                    Invoices
                </a>

                <a href="{{ route('giro.index') }}" class="my-1 mr-2 btn btn-info btn-lg">
                    <i class="fa fa-money"></i>
                    Giros
                </a>
            </p>
        </div>
    </div>
</div>

@endsection
