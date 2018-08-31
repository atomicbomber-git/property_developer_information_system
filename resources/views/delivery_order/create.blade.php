@extends('shared.layout')

@section('title', 'Create New Delivery Order')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('delivery_order.index') }}"> Delivery Order (From Vendor) </a> </li>
            <li class="breadcrumb-item active"> Tambahkan Delivery Order Baru </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Tambahkan Delivery Order Baru
            </h1>

            <hr class="mt-2 mb-2">

            <form
                id="create-delivery-order-form"
                method='POST'
                action='{{ route('delivery_order.create') }}'>
                @csrf

                <div class='form-group'>
                    <label for='receiver_id'> Penerima Delivery Order: </label>
                    <select name='receiver_id' id='receiver_id' class='form-control'>
                        @foreach($users as $user)
                        <option {{ old('receiver_id') !== $user->id ?: 'selected' }} value='{{ $user->id }}'> {{ $user->name }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('receiver_id') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='target_id'> Storage: </label>
                    <select name='target_id' id='target_id' class='form-control'>
                        @foreach($storages as $storage)
                        <option {{ old('target_id') != $storage->id ?: 'selected' }} value='{{ $storage->id }}'> {{ $storage->name }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('target_id') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='received_at'> Tanggal Penerimaan: </label>
                
                    <input
                        id='received_at' name='received_at' type='date'
                        value='{{ old('received_at', today()->format('Y-m-d')) }}'
                        class='form-control {{ !$errors->has('received_at') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('received_at') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='source_id'> Vendor: </label>
                    <select id="select-vendor" name='source_id' id='source_id' class='form-control'>
                        @foreach($vendors as $vendor)
                        <option {{ old('source_id') == $vendor->id ? 'selected' : '' }} value='{{ $vendor->id }}'> {{ $vendor->name }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('source_id') }}
                    </div>
                </div>

                <div class="form-group">
                    <label for="select-item"> Pick Item: </label>
                    
                    <div class="form-row">
                        <div class="col">
                            <select id="select-item" class="form-control">
                                {{-- Should be automatically inserted --}}
                            </select>
                        </div>
                        <div class="col-2">
                            <button id="btn-add-item" type="button" class="btn w-100">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="select-item"> Items to Be Added: </label>

                    <div id="item-input-template" class="d-none input-row form-row mt-4">
                        <div class="col">
                            <input type="hidden" class="input-id">
                            <input type="text" class="input-name form-control form-control-sm" readonly>
                        </div>
                        <div class="col-2">
                            <input type="number" value="0" class="input-quantity form-control form-control-sm">
                        </div>
                        <div class="col-2">
                            <button type="button" class="btn-delete btn btn-danger btn-outline-danger btn-sm">
                                <i class="fa fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div id="item-input-container">
                        @if(old('delivery_items'))
                            @foreach(old('delivery_items') as $key => $delivery_item)
                            <div class="input-row form-row mt-4">
                                <div class="col">
                                    <input name="delivery_items[{{ $key }}][id]" type="hidden" value="{{ $delivery_item['id'] }}" class="input-id">
                                    <input type="text" class="input-name form-control form-control-sm {{ $errors->first("delivery_items.$delivery_item[id].quantity", 'is-invalid') }}" readonly>
                                    <div class="invalid-feedback">
                                        {{ $errors->first("delivery_items.$delivery_item[id].quantity") }}
                                    </div>
                                </div>

                                <div class="col-2">
                                    <input
                                        name="delivery_items[{{ $key }}][quantity]"
                                        type="number" value="{{ $delivery_item['quantity']  }}"
                                        class="input-quantity form-control form-control-sm">
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn-delete btn btn-danger btn-outline-danger btn-sm">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>
                </div>

                <script>
                    let $select_item = $('#select-item');
                    let $select_vendor = $('#select-vendor');
                    let $item_input_container = $('#item-input-container');
                    let $default_clone = $('#item-input-template').clone()
                        .removeAttr('id')
                        .removeClass('d-none');
                    
                    let vendor_items = [];
                    let used_item_ids = [];

                    $(document).ready(() => {

                        // Enable vendor selections just before submitting the form.
                        $('#create-delivery-order-form').submit(() => {
                            $select_vendor.prop("disabled", false);
                        });

                        let input_rows = $item_input_container.find('.input-row');
                        if (input_rows.length) {
                            $select_vendor.prop("disabled", true);
                        } 

                        axios.get(`/vendor/item/${$select_vendor.val()}`)
                            .then(response => {
                                $select_item.empty();
                                vendor_items = response.data;
                                vendor_items.forEach(item => {
                                    $select_item.append(`<option value='${item.id}'> ${item.name} </option>`);
                                });

                                input_rows.each((i, elem) => {
                                    let item_id = $(elem).find('.input-id').val();
                                    let item_name = _.find(vendor_items, {id: parseInt(item_id)}).name;
                                    $(elem).find('.input-name').val(item_name);
                                    used_item_ids.push(item_id);

                                    $(elem).find('.btn-delete').click(function() {
                                        $(elem).remove();
                                        // $item_input_container.find(`[data-item-id=${item_id}]`).remove();
                                        used_item_ids = used_item_ids.filter(id => id != item_id);
                                        if (used_item_ids.length == 0) {
                                            $select_vendor.prop("disabled", false);
                                        }
                                    });
                                });
                            })

                        $select_vendor.change(function() {
                            adjustItemSelections($(this).val());
                        });

                        $('#btn-add-item').click(() => {
                            let new_item_id = $select_item.val();

                            if (used_item_ids.includes(new_item_id)) {
                                alert("Item already in list.");
                                return;
                            }
                            
                            $select_vendor.prop("disabled", true);
                            used_item_ids.push(new_item_id);

                            $cloned = $default_clone.clone();
                            $cloned.find('.input-name').val($select_item.find(':selected').text());

                            $cloned.find('.input-id').attr('name', `delivery_items[${new_item_id}][id]`);
                            $cloned.find('.input-id').val(new_item_id);
                            $cloned.find('.input-quantity').attr('name', `delivery_items[${new_item_id}][quantity]`);
                            
                            $cloned.find('.btn-delete').click(function() {
                                $item_input_container.find(`[data-item-id=${new_item_id}]`).remove();
                                used_item_ids = used_item_ids.filter(id => id != new_item_id);
                                if (used_item_ids.length == 0) {
                                    $select_vendor.prop("disabled", false);
                                }
                            });

                            $cloned.appendTo($item_input_container);
                            $cloned.attr("data-item-id", new_item_id);

                        });
                    });

                    function adjustItemSelections(vendor_id) {
                        axios.get(`/vendor/item/${vendor_id}`)
                            .then(response => {
                                $select_item.empty();
                                vendor_items = response.data;
                                vendor_items.forEach(item => {
                                    $select_item.append(`<option value='${item.id}'> ${item.name} </option>`);
                                });
                            })
                    }
                </script>

                <div class="text-right mt-5">
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