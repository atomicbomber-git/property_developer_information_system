@extends('shared.layout')

@section('title', "Transaction History of Vendor '$vendor->name'")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('vendor.index') }}"> Vendor </a> </li>
            <li class="breadcrumb-item"> Transaction History of Vendor '{{ $vendor->name }}' </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-truck"></i>
                Transaction History of Vendor '{{ $vendor->name }}'
            </h1>

            <hr class="mt-2 mb-2">

            @include('shared.message-success')
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Invoice </th>
                            <th> Date </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($invoices as $invoice)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td>
                                <a target="_blank" href="{{ route('invoice.pay', $invoice->invoice_id) }}">
                                    {{ $vendor->code . '-' . $invoice->invoice->id  }}
                                </a>
                            </td>
                            <td>
                                {{ $invoice->invoice->received_at->format('l, j F Y') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection