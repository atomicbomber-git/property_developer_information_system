@extends('shared.layout')

@section('title', 'All Delivery Orders (From Vendor)')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Delivery Order (From Vendor) </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-credit-card"></i>
                Kelola Delivery Order (From Vendor)
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('delivery_order.create') }}" class="btn btn-secondary btn-sm">
                    Tambahkan Delivery Order Baru
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <table class="table table-sm table-striped table-responsive-xl">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Penerima </th>
                        <th> Tanggal </th>
                        <th> Vendor (Source) </th>
                        <th> Storage (Target) </th>
                        <th> Kendali </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($delivery_orders as $delivery_order)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ optional($delivery_order->receiver)->name }} </td>
                        <td>
                            {{ $delivery_order->received_at->format('l, j F Y') }} <br>
                            <span class="text-secondary"> {{ $delivery_order->received_at->ago() }} </span>
                        </td>
                        <td> {{ optional($delivery_order->source)->name }} </td>
                        <td> {{ optional($delivery_order->target)->name }} </td>
                        <td>
                            <a href="{{ route('delivery_order.detail', $delivery_order) }}" class="btn mb-1 mr-2 btn-dark btn-sm">
                                Detail
                                <i class="fa fa-list-alt"></i>
                            </a>

                            <a href="{{ route('delivery_order.update', $delivery_order) }}" class="btn mb-1 btn-dark btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <form method="POST" class="d-inline-block" action="{{ route('delivery_order.delete', $delivery_order) }}">
                                @csrf
                                <button class="btn mb-1 btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
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
@endsection