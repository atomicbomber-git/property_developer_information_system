@extends('shared.layout')

@section('title', 'All Vendors')

@section('content')

<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
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
                <a href="{{ route('vendor.index') }}" class="btn btn-info btn-lg">
                    <i class="fa fa-shopping-cart"></i>
                    Vendors
                </a>

                <a href="{{ route('item.index') }}" class="btn btn-info btn-lg">
                    <i class="fa fa-list"></i>
                    Items
                </a>

                <a href="{{ route('storage.index') }}" class="btn btn-info btn-lg">
                    <i class="fa fa-truck"></i>
                    Storages
                </a>
            </p>
        </div>
    </div>
</div>

@endsection