@extends('shared.layout')

@section('title', "Update Giro $giro->id")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('giro.index') }}"> Giros </a> </li>
            <li class="breadcrumb-item active"> Update Giro {{ $giro->id }} </li>
        </ol>
    </nav>

    <div class="card" style="width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-money"></i>
                Update Giro
            </h1>

            <hr class="mt-2 mb-2">

            @include('shared.message-success')
            
            <form method="POST" action="{{ route('giro.update', $giro) }}">
                @csrf

                <div class='form-group'>
                    <label for='number'> Number: </label>
                
                    <input
                        id='number' name='number' type='text'
                        value='{{ old('number', $giro->number) }}'
                        class='form-control {{ !$errors->has('number') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('number') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='amount'> Amount (Rp): </label>
                
                    <input
                        id='amount' name='amount' type='number'
                        value='{{ old('amount', $giro->amount) }}'
                        class='form-control {{ !$errors->has('amount') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('amount') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='transfered_at'> Transfer Date: </label>
                
                    <input
                        id='transfered_at' name='transfered_at' type='date'
                        value='{{ old('transfered_at', optional($giro->transfered_at)->format('Y-m-d')) }}'
                        class='form-control {{ !$errors->has('transfered_at') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('transfered_at') }}
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary btn-sm">
                        Update
                        <i class="fa fa-check"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-usd"></i>
                Invoices Paid Using this Giro
            </h1>

            <hr class="mt-2 mb-2">
            
            @foreach ($invoices as $invoice_id => $invoice)
            
            <a class="h5 d-block mb-2" href="{{ route('invoice.pay', $invoice_id) }}">
                {{ $loop->iteration }}. Invoice {{ $invoice_id }}
            </a>

            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Item </th>
                            <th> Unit </th>
                            <th class="text-right"> Quantity </th>
                            <th class="text-right"> Price (Rp) </th>
                            <th class="text-right"> Subtotal (Rp) </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($invoice as $item)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $item->name }} </td>
                            <td> {{ $item->unit }} </td>
                            <td class="text-right"> {{ $item->quantity_subtotal }} </td>
                            <td class="text-right"> @convert_money($item->price) </td>
                            <td class="text-right"> @convert_money($item->price_subtotal) </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4"></td>
                            <td colspan="1" class="text-right"> <strong> Total: </strong> </td>
                            <td class="text-right"> @convert_money($price_sums->get($invoice_id)) </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endforeach

            <div class="text-right">
                <p class="h1 font-bold">
                    TOTAL:
                    <span class="text-danger"> Rp. @convert_money($price_sums->sum()) </span>
                </p>
            </div>

        </div>
    </div>
</div>
@endsection