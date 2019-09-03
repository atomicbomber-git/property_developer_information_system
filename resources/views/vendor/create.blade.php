@extends('shared.layout')

@section('title', 'Create New Vendor')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> <a href="{{ route('vendor.index') }}"> Vendor </a> </li>
            <li class="breadcrumb-item active"> Tambahkan Vendor Baru </li>
        </ol>
    </nav>

    <div class="card mb-5" style="max-width: 35rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Tambahkan Vendor Baru
            </h1>

            <hr class="mt-2 mb-2">

            <div id="create-vendor-form">
                <CreateVendorForm/>
            </div>
        </div>
    </div>
</div>
@endsection
