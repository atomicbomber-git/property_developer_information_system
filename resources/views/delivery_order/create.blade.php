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
                    <label for='source_id'> Vendor: </label>
                    <select name='source_id' id='source_id' class='form-control'>
                        @foreach($vendors as $vendor)
                        <option {{ old('source_id') !== $vendor->id ?: 'selected' }} value='{{ $vendor->id }}'> {{ $vendor->name }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('source_id') }}
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