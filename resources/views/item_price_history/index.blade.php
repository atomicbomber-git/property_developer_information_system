@inject('formatter', 'App\Helpers\Formatter')


@extends('shared.layout')
@section('title', 'Item Price History')
@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item">
                <a href="{{ route('item.index') }}">
                    Item
                </a>
            </li>
            <li class="breadcrumb-item active">
                Item Price History
            </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class='h5'>
                <i class='fa fa-line-chart'></i>
                Item Price History
            </h1>

            <hr class="mt-2 mb-2">

            <div class='table-responsive'>
                <table class='datatable table table-sm table-bordered table-striped'>
                   <thead class='thead thead-dark'>
                        <tr>
                            <th> # </th>
                            <th class="text-right"> Price </th>
                            <th class="text-right"> Received At </th>
                        </tr>
                   </thead>

                   <tbody>
                       @foreach ($delivery_order_items as $delivery_order_item)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td class="text-right">
                                {{ $formatter->currency($delivery_order_item->price) }}
                            </td>
                            <td class="text-right">
                                {{ $delivery_order_item->delivery_order_received_at }}
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
