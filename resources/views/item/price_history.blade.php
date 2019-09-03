@extends('shared.layout')

@section('title', "Price History of '$item->name'")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('category.index') }}"> Category </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('item.index', [$category, $item]) }}"> Items in '{{ $category->name }}' </a> </li>
            <li class="breadcrumb-item"> Price History of '{{ $item->name }}' </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 30rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-line-chart"></i>
                Price History of '{{ $item->name }}'
            </h1>

            <hr class="mt-2 mb-2">

            @include('shared.message-success')

            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 1rem"> # </th>
                            <th style="width: 10rem" class="text-right pr-5"> Price (Rp) </th>
                            <th> Date </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($item_prices as $item_price)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td class="text-right pr-5"> @convert_money($item_price->price) </td>
                            <td> @format_date($item_price->received_at) </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div>
                {{ $item_prices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
