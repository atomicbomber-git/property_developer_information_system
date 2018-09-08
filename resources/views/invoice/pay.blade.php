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
                
                Invoice {{ $invoice->id }} From <a href="{{ route('vendor.transaction_history', $vendor->id) }}"> {{ $vendor->name }} </a> at {{ $invoice->received_at->format('d-m-Y')  }}

                @switch($invoice->payment_method)
                    @case('cash')
                    <span class="badge badge-primary">
                        Paid With Cash
                    </span>
                    @break

                    @case('giro')
                    <a target="_blank" href="{{ route('giro.update', $invoice->giro_id) }}" class="badge {{ $invoice->giro->transfered_at ? 'badge-success' : 'badge-primary' }}">
                        Paid With Giro {{ $invoice->giro_id }}
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

            <div class="form-group text-right mt-3">
                <div class="d-inline-block text-left mb-4" style="width: 15rem">
                    <label for="payment_method"> Payment Method: </label>
                    <select form="pay-form" class="form-control form-control-sm mb-2" name="payment_method" id="payment-method">
                        <option {{ old('payment_method', $invoice->payment_method) == 'cash' ? 'selected' : '' }} value="cash"> Cash </option>
                        <option {{ old('payment_method', $invoice->payment_method) == 'giro' ? 'selected' : '' }} value="giro"> Giro Lama </option>
                        <option {{ old('payment_method') == 'new_giro' ? 'selected' : '' }} value="new_giro"> Giro Baru </option>
                    </select>

                    <div id="extra-field" class="mt-4"></div>

                    <button type="submit" form="pay-form" class="mt-4 w-100 btn btn-primary btn-sm">
                        Update Payment
                        <i class="fa fa-usd"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="cash-amount-field" class='form-group d-none'>
    <label for='cash_amount'> Cash Amount: </label>

    <input
        id='cash_amount' form="pay-form" name='cash_amount' type='number'
        value='{{ old('cash_amount', $invoice->cash_amount) }}'
        class='form-control form-control-sm {{ !$errors->has('cash_amount') ?: 'is-invalid' }}'>

    <div class='invalid-feedback'>
        {{ $errors->first('cash_amount') }}
    </div>
</div>

<div id="existing-giro-field" class='form-group d-none'>
    <label for='giro_id'> Filter Giro Choices: </label>
    <input id="giro-search" type="text" class="form-control form-control-sm mb-2" placeholder="Filter by ID">

    <label for='giro_id'> Pick Giro: </label>
    <select form="pay-form" class="form-control form-control-sm" name="giro_id" id="giro_id">
        
        @if($invoice->giro_id != NULL)
        <option id="current-giro" value="{{ $invoice->giro->id }}" selected> Giro {{ $invoice->giro->id }} </option>
        @endif

        @foreach ($latest_giro_ids as $latest_giro_id)
        <option class="changeable" value="{{ $latest_giro_id }}"> Giro {{ $latest_giro_id }} </option>
        @endforeach
        
    </select>

    <div class='invalid-feedback'>
        {{ $errors->first('giro_id') }}
    </div>
</div>
@endsection

@section('script')
<script>
    // ---------------------- SHOW WARNING ON EXIT EXCEPT ON FORM SUBMIT -------------------------
    let is_submitting = false;

    $('form#pay-form').submit(() => {
        is_submitting = true;
    });
    
    window.onbeforeunload = function() {
        if ($('.is-invalid').length) {
            if (!is_submitting) {
                return "Pencatatan pembayaran belum sukses dilakukan, Anda yakin ingin keluar dari halaman ini?";
            }
        }
    }
    // --------------------------------------------------------------------------------------------

    // ---------------------- ADJUST INPUT FIELDS ACCORDING TO PAYMENT METHOD ---------------------
    let payment_method_select_elem = $('#payment-method');
    let extra_field_elem = $('#extra-field');

    let cash_amount_field = $('#cash-amount-field').clone().removeClass('d-none');
    let existing_giro_field = $('#existing-giro-field').clone().removeClass('d-none');
    $('#cash-amount-field').empty();
    $('#existing-giro-field').empty();

    adjustPaymentMethodFields(payment_method_select_elem.val());

    payment_method_select_elem.change(function() {
        adjustPaymentMethodFields($(this).val());
    });

    function adjustPaymentMethodFields(payment_method)
    {
        extra_field_elem.empty();

        switch (payment_method) {
            case 'cash':
                extra_field_elem.append(cash_amount_field);
                break;
            case 'new_giro':
                // Supposed to do nothing
                break;
            case 'giro':
                extra_field_elem.append(existing_giro_field);
                break;
        }
    }
    //---------------------------------------------------------------------------------------------

    // ---------------------- GIRO FILTER / SEARCH ------------------------------------------------
    let getGiros = function (giro_id)
    {
        axios.get('{{ route('giro.search') }}', {
                params: {
                    id: giro_id
                }
            })
            .then(response => {

                existing_giro_field
                    .find('#giro_id')
                    .find('option.changeable')
                    .remove();

                response.data.forEach(giro_id => {

                    let current_giro = $('option#current-giro');
                    if (current_giro.length && current_giro.attr('value') == giro_id) {
                        return;
                    }

                    existing_giro_field.find('#giro_id')
                        .append(`<option value="${giro_id}" class='changeable'> Giro ${giro_id} </option>`);
                });
            });
    }

    existing_giro_field.find('#giro-search')
        .on('change textInput input', _.debounce(function() { getGiros($(this).val()); }, 400));
    // --------------------------------------------------------------------------------------------

</script>
@endsection