@extends('shared.layout')

@section('title', 'Create New Stock Adjustment')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('storage.index') }}"> Storage </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('storage-stock.index', $storage) }}"> Storage '{{ $storage->name }}' </a> </li>
            <li class="breadcrumb-item active"> Stock Adjustment </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                Add Stock Adjustment
            </h1>

            <hr class="mt-2 mb-2">

            @include('shared.message-success')

            <div id="app">
                <storage-stock-adjustment-create
                    submit_url="{{ route('storage-stock-adjustment.store', $storage) }}"
                    redirect_url="{{ route('storage-stock-adjustment.create', $storage) }}"
                    :items='{{ $items }}'
                    :storage='{{ $storage }}'
                    >
                </storage-stock-adjustment-create>
            </div>
        </div>
    </div>
</div>
@endsection
