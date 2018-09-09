@extends('shared.layout')

@section('title', "Payment of Invoice $invoice->id")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('invoice.index') }}"> Invoice </a> </li>
            <li class="breadcrumb-item active"> Pay Invoice {{ $invoice->id }} </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-usd"></i>
                
                Invoice From <a href="{{ route('vendor.transaction_history', $vendor->id) }}"> {{ $vendor->name }} </a> at {{ $invoice->received_at->format('d-m-Y')  }}

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
                            <th class="text-right"> Subtotal (Rp) </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($delivery_orders as $delivery_order)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td>
                                <a target="_blank" href="{{ route('delivery_order.update_price', $delivery_order->id) }}">
                                    Delivery Order {{ $delivery_order->id }}
                                    ({{ ( new Date ($delivery_order->received_at) )->format('d-m-Y')  }})
                                </a>
                            </td>
                            <td class="text-right"> @convert_money($delivery_order->subtotal) </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td></td>
                            <td class="text-right"> <strong> Total: </strong> </td>
                            <td id="total" class="text-right"> @convert_money($delivery_orders->sum->subtotal) </td>
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
</div>
@endsection