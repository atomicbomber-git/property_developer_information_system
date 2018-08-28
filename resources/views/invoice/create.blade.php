@extends('shared.layout')

@section('title', 'Create New Invoice')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('invoice.index') }}"> Invoice </a> </li>
            <li class="breadcrumb-item active"> Tambahkan Invoice Baru </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 40rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Tambahkan Invoice Baru
            </h1>

            <hr class="mt-2 mb-2">

            @if($errors->has('delivery_orders'))
            <div class="alert alert-danger">
                Pembuatan Invoice gagal! Anda wajib memilih minimal satu (1) Delivery Order!
            </div>
            @endif

            <form
                id="delivery-order-form"
                method='POST'
                action='{{ route('invoice.create') }}'>
                @csrf

                <div class='form-group'>
                    <label for='vendor'> Vendor: </label>
                    <select name="vendor_id" id='vendor' class='form-control'>
                        @foreach($vendors as $vendor)
                        <option value="{{ $vendor->id }}" data-url="{{ route('vendor.unbilled_delivery_orders', $vendor->id) }}">
                            {{ $vendor->name }}
                        </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('vendor_id') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="delivery_orders">
                        Delivery Orders:
                    </label>

                    <div id="delivery-order-list" class="list-group">
                    </div>

                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-primary btn-sm">
                        Tambahkan
                        <i class="fa fa-plus"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    let selected_delivery_orders = [];

    function loadDeliveryOrderOptions(url)
    {
        let list = document.getElementById('delivery-order-list');
        let loading_alert = $('<div class="list-group-item list-group-item-info"> Loading... </div>');
        $(list).empty();
        $(list).append(loading_alert);

        $.ajax({
            method: 'GET',
            url: url
        })
        .then(delivery_orders => {

            selected_delivery_orders = [];

            if (delivery_orders.length == 0) {
                let list_item = document.createElement('div');
                list_item.classList.add('list-group-item');
                list_item.classList.add('list-group-item-danger');
                list_item.textContent = "Tidak ada Delivery Order dari Vendor ini yang belum dimasukkan ke dalam Invoice."
                list.appendChild(list_item);
            }

            delivery_orders.forEach(delivery_order => {
                
                let list_item = document.createElement('div');
                list_item.classList.add('list-group-item');
                list_item.classList.add('list-group-item-action');
                
                let list_item_title = document.createElement('h5');
                list_item_title.innerHTML = `Delivery Order ${delivery_order.id}`;
                list_item.appendChild(list_item_title);

                let list_item_ol = document.createElement('ol');
                delivery_order.delivery_order_items.forEach(delivery_order_item => {
                    let li = document.createElement('li');
                    li.innerText = `${delivery_order_item.item.name} × ${delivery_order_item.quantity}`;
                    list_item_ol.appendChild(li);
                });
                
                list_item.appendChild(list_item_ol);
                list.appendChild(list_item);

                $(list_item).click(() => {

                    if (selected_delivery_orders.includes(delivery_order.id)) {
                        selected_delivery_orders = selected_delivery_orders.filter(order_id => {
                            return order_id !== delivery_order.id;
                        });
                    }
                    else {
                        selected_delivery_orders.push(delivery_order.id);
                    }
                    
                    $(list_item).toggleClass('list-group-item-warning');
                    console.log(selected_delivery_orders);
                })
            });

            loading_alert.remove();
        })
        .catch(error => {
            loading_alert.remove();
            console.log('Error');
        })
    }

    $(document).ready(() => {

        // Load options
        loadDeliveryOrderOptions($('#vendor').find(':selected').data('url'));

        $('#vendor').change(function() {
            let selected = $(this).find(':selected');
            loadDeliveryOrderOptions(selected.data('url'));
        });

        $('#delivery-order-form').submit(function (e) {
            e.preventDefault();
            
            selected_delivery_orders.forEach(id => {
                $(this).append($(`<input type='hidden' name='delivery_orders[]' value=${id}>`));
            })

            $(this).off('submit').submit();
        });
    });
</script>
@endsection