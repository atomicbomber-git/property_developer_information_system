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

            @include('shared.message-success')
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Item </th>
                            <th class="text-right"> Stock </th>
                            <th> Unit </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item_stocks as $item_stock)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $item_stock->name }} </td>
                            <td class="text-right"> {{ str_replace(".0000", "", number_format($item_stock->stock, 4)) }} </td>
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