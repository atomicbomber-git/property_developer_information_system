@inject('formatter', \App\Helpers\Formatter)

@extends('shared.layout')

@section('title', 'Delivery Orders (From Vendor)')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Delivery Order (From Vendor) </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-credit-card"></i>
                Delivery Order (From Vendor)
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('delivery-order.create') }}" class="btn btn-secondary btn-sm">
                    Add Delivery Order
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <div class="table-responsive">
                <table class="datatable table table-sm table-striped table-responsive-xl">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Receiver </th>
                            <th> Date </th>
                            <th> Vendor (Source) </th>
                            <th> Storage (Target) </th>
                            <th> Controls </th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @foreach ($delivery_orders as $delivery_order)
                        <tr>
                            <td> {{ $delivery_orders->firstItem() + $loop->index }}. </td>
                            <td> {{ $delivery_order->receiver->name }} </td>
                            <td> {{ $formatter->date($delivery_order->received_at) }} </td>
                            <td> {{ $delivery_order->source->name }} </td>
                            <td> {{ $delivery_order->target->name }} </td>
                            <td>
                                <a href="{{ route('delivery-order.edit', $delivery_order) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                <form method="POST" class="d-inline-block" action="{{ route('delivery-order.delete', $delivery_order) }}">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @parent

    <script>
        $(document).ready(function() {
            $("table.datatable").dataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('delivery-order.index') }}',

                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'id',
                        width: '5%',
                    },
                    { data: 'receiver.name', name: 'receiver.name' },
                    { data: 'received_at', name: 'received_at' },
                    { data: 'source.name', name: 'source_name' },
                    { data: 'target.name', name: 'target_name' },
                    {
                        data: 'controls',
                        className: 'text-center',
                        orderable: false,
                        searchable: false,
                        width: '20%',
                    }
                ],

            })
        })
    </script>
@endsection
