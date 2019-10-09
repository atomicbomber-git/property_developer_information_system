@inject('formatter', 'App\Helpers\Formatter')

@extends('shared.layout')

@section('title', "Payment of Invoice $invoice->id")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('invoice.index') }}"> Invoice </a> </li>
            <li class="breadcrumb-item active"> Pay Invoice {{ $invoice->id }} </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-usd"></i>

                Invoice <strong> {{ $invoice->number }} </strong> From {{ $vendor->name }} at {{ $invoice->received_at->format('d-m-Y')  }}

                @switch($invoice->payment_method)
                    @case('cash')
                    <span class="badge badge-primary">
                        Paid With Cash
                    </span>
                    @break

                    @case('giro')
                    <a target="_blank" href="{{ route('giro.update', $invoice->giro_id) }}" class="badge {{ $invoice->giro->transfered_at ? 'badge-success' : 'badge-primary' }}">
                        Paid With Giro {{ $invoice->giro->number }}
                    </a>
                    @break

                    @default
                    <span class="badge badge-danger"> Unpaid </span>
                @endswitch

            </h1>

            <hr class="mt-2 mb-2">

            @include('shared.message-success')

            <form method="POST" id="pay-form" action="{{ route('invoice.pay', $invoice) }}">
                @csrf
            </form>

            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Delivery Order </th>
                            <th> Source </th>
                            <th> Target </th>
                            <th class="text-right"> Subtotal (Rp) </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($delivery_orders as $delivery_order)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td>
                                <a target="_blank" href="{{ route('delivery-order.update_price', $delivery_order->id) }}">
                                    Delivery Order {{ $delivery_order->id }}
                                    ({{ ( new Date ($delivery_order->received_at) )->format('d-m-Y')  }})
                                </a>
                            </td>
                            <td> {{ $delivery_order->source_name }} </td>
                            <td> <a href="{{ route('storage-stock.index', $delivery_order->target_id) }}"> {{ $delivery_order->target_name }} </a> </td>
                            <td class="text-right">
                                {{ $formatter->currency($delivery_order->subtotal) }}
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="text-right"> <strong> Total: </strong> </td>
                            <td id="total" class="text-right">
                                {{ $formatter->currency($delivery_orders->sum->subtotal) }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="form-group text-right mt-3 text-right">
                <span id="invoice-id" data-invoice-id="{{ $invoice->id }}"></span>
                <div id="update-invoice-payment-form" class="d-inline-block" style="width: 20rem">
                    <UpdateInvoicePaymentForm/>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
           <div class='table-responsive'>
                @foreach ($detailed_delivery_orders as $id => $delivery_order_items)

                <h4> {{ $loop->iteration }}. <a href="{{ route('delivery-order.update_price', $id)}}"> Delivery Order {{ $id }} </a> </h2>
                <p class="lead"> Delivered to <a href="{{ route('storage-stock.index', $delivery_orders[$id]->target_id) }}"> {{ $delivery_orders[$id]->target_name }} </a> </p>

                <table class='table table-sm table-striped mb-5'>
                    <thead class="thead-dark">
                        <tr>
                            <th> Name </th>
                            <th class="text-right"> Quantity </th>
                            <th class="text-right"> Price (Rp.) </th>
                            <th class="text-right"> Subtotal (Rp.) </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($delivery_order_items as $item)
                            <tr>
                                <td> {{ $item->name }} </td>
                                <td class="text-right"> {{ $formatter->number($item->quantity) }} </td>
                                <td class="text-right"> {{ $formatter->currency($item->price) }} </td>
                                <td class="text-right"> {{ $formatter->currency($item->subtotal) }} </td>
                            </tr>
                        @endforeach
                        <tr class="font-weight-bold">
                            <td></td>
                            <td></td>
                            <td class="text-right"> Total: </td>
                            <td class="text-right"> {{ $formatter->currency($delivery_order_items->sum("subtotal")) }} </td>
                        </tr>
                    </tbody>
                    </table>
                @endforeach
           </div>
        </div>
    </div>
</div>
@endsection
