@extends('shared.layout')

@section('title', "Item Stocks of Storage '$storage->name'")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('storage.index') }}"> Storage </a> </li>
            <li class="breadcrumb-item"> Stocks </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-truck"></i>
                Item Stocks of Storage {{ $storage->name }} 
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('storage.create') }}" class="btn btn-secondary btn-sm">
                    Tambahkan Storage Baru
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Item </th>
                            <th> Stock </th>
                            <th> Unit </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item_stocks as $item_stock)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $item_stock->name }} </td>
                            <td> {{ $item_stock->stock }} </td>
                            <td> {{ $item_stock->unit }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection