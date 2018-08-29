@extends('shared.layout')

@section('title', 'All Invoices')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Invoice </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-usd"></i>
                Kelola Invoice
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('invoice.create') }}" class="btn btn-secondary btn-sm">
                    Tambahkan Invoice Baru
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Invoice </th>
                        <th> Status </th>
                        <th> Receivement Date </th>
                        <th> Control </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                    <tr>
                        <td> {{ $invoices->firstItem() + $loop->index }}. </td>
                        <td> Invoice {{ $invoice->id }} </td>
                        <td>
                            @switch($invoice->payment_method)
                                @case('cash')
                                <span class="badge badge-success">
                                    Paid With Cash
                                </span>
                                @break

                                @case('giro')
                                <a href="{{ route('giro.update', $invoice->giro_id) }}" class="badge {{ $invoice->giro->transfered_at ? 'badge-success' : 'badge-primary' }}">
                                    Paid With Giro {{ $invoice->giro_id }}
                                </a>
                                @break

                                @default
                                <span class="badge badge-danger"> Unpaid </span>
                            @endswitch
                        </td>

                        <td>
                            {{ $invoice->received_at->format('d-m-Y') }}
                        </td>

                        <td>
                            <a href="{{ route('invoice.pay', $invoice) }}" class="btn btn-dark mr-2 btn-sm">
                                Payment
                                <i class="fa fa-usd"></i>
                            </a>

                            <a href="{{ route('invoice.update', $invoice) }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <form method="POST" class="d-inline-block" action="{{ route('invoice.delete', $invoice) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
            </table>

            <div class="text-center">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @include('shared.activate-tooltip')
@endsection