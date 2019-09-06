@inject('formatter', App\Helpers\Formatter)

@extends('shared.layout')
@section('title', 'Storage Stocks')
@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item">
                <a href="{{ route('storage.index') }}">
                    Storage
                </a>
            </li>
            <li class="breadcrumb-item active"> Stock </li>
        </ol>
    </nav>


    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-list"></i>
                Storage Stocks
            </h1>

            <hr class="mr-2 mb-2">

            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Item </th>
                            <th> Quantity </th>
                            <th> Unit </th>
                            <th> Entry Date </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($storage->stocks as $stock)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $stock->item->name }} </td>
                            <td> {{ $formatter->number($stock->quantity) }} </td>
                            <td> {{ $stock->item->unit }} </td>
                            <td> {{ $formatter->date($stock->created_at) }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
