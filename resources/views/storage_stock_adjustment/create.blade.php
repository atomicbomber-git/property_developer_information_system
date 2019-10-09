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

    <div class="card" style="max-width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                Add Stock Adjustment
            </h1>

            <hr class="mt-2 mb-2">




        </div>
    </div>
</div>
@endsection
