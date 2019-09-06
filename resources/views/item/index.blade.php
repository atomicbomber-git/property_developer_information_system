@inject('formatter', "App\Helpers\Formatter")

@extends('shared.layout')
@section('title', 'Items')
@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Item </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-cubes"></i>
                Item
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('item.create') }}" class="btn btn-secondary btn-sm">
                    Add Item
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <div class='table-responsive'>
                <table class='datatable table table-sm table-bordered table-striped'>
                    <thead class='thead thead-dark'>
                        <tr>
                            <th> # </th>
                            <th style="width: 5rem"> Name </th>
                            <th> Vendor </th>
                            <th> Category </th>
                            <th class="text-right"> Latest Price </th>
                            <th class="text-center" style="width: 10rem"> Controls </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($items as $item)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $item->name }} </td>
                            <td> {{ join(", ", $item->vendors->pluck("name")->toArray()) }} </td>
                            <td> {{ $item->category->name }} </td>
                            <td class="text-right"> {{ $formatter->currency($item->latest_price) }} </td>
                            <td class="text-center">
                                <a class="btn btn-dark btn-sm" href="{{ route('item-price-history.index', $item) }}">
                                    Price History
                                    <i class="fa fa-line-chart"></i>
                                </a>

                                <a class="btn btn-dark btn-sm" href="{{ route('item.edit', $item) }}">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form action='{{ route('item.delete', $item) }}' method='POST' class='d-inline-block'>
                                    @csrf
                                    <button type='submit' class='btn btn-danger btn-sm'>
                                        <i class='fa fa-trash'></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @parent
    @include('shared.datatables')
@endsection
