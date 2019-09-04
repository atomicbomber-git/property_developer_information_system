@inject('formatter', "App\Helpers\Formatter")

@extends('shared.layout')
@section('title', 'Item')
@section('content')
<div class="container my-5">
    <div class="container">
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

                <div class='table-responsive'>
                    <table class='datatable table table-sm table-bordered table-striped'>
                       <thead class='thead thead-dark'>
                            <tr>
                                <th> # </th>
                                <th> Name </th>
                                <th> Vendor </th>
                                <th> Category </th>
                                <th class="text-right"> Latest Price </th>
                                <th class="text-center"> Controls </th>
                            </tr>
                       </thead>

                       <tbody>
                           @foreach ($items as $item)
                            <tr>
                                <td> {{ $loop->iteration }}. </td>
                                <td> {{ $item->name }} </td>
                                <td> {{ $item->vendor->name }} </td>
                                <td> {{ $item->category->name }} </td>
                                <td class="text-right"> {{ $formatter->currency($item->latest_price) }} </td>
                                <td class="text-center">
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
</div>
@endsection

@section('script')
    @parent
    @include('shared.datatables')
@endsection
