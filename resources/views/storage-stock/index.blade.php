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
                Storage Stocks of {{ $storage->name }}
            </h1>

            <hr class="mr-2 mb-2">

            <div class="d-flex justify-content-end mb-5 mt-3">
                <a
                    href="{{ route('storage-stock-adjustment.create', $storage) }}"
                    class="btn btn-dark btn-sm">
                    Stock Adjustment
                </a>
            </div>

            <div class="table-responsive">
                <table class="datatable table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Item </th>
                            <th> Quantity </th>
                            <th> Unit </th>
                            <th class="text-right"> Value </th>
                            <th> Origin </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($storage->stocks as $stock)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $stock->item->name }} </td>
                            <td> {{ $formatter->number($stock->quantity) }} </td>
                            <td> {{ $stock->item->unit }} </td>
                            <td class="text-right"> {{ $formatter->currency($stock->value) }} </td>
                            <td>
                                @if ($stock->origin instanceof \App\StockAdjustment)
                                STOCK ADJUSTMENT <br/>
                                {{ $formatter->date($stock->origin->created_at) }}
                                @elseif ($stock->origin instanceof \App\DeliveryOrderItem)
                                {{ $stock->origin->delivery_order->source->name }} <br/>
                                {{ $formatter->date($stock->origin->delivery_order->received_at) }}
                                @endif

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
