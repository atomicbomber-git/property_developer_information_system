@extends('shared.layout')

@section('title', 'All Vendors')

@section('content')

<div class="container">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">
                <i class="fa fa-cog"> </i>
                Dashboard
            </h5>

            <p class="card-text">
                <a href="{{ route('vendor.index') }}" class="btn btn-info btn-sm">
                    <i class="fa fa-shopping-cart"></i>
                    Vendors
                </a>

                <a href="" class="btn btn-info btn-sm">
                    <i class="fa fa-list"></i>
                    Items
                </a>
            </p>
        </div>
    </div>
</div>

@endsection