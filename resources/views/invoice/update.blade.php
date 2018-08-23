@extends('shared.layout')

@section('title', 'Update Invoice')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('invoice.index') }}"> Invoice </a> </li>
            <li class="breadcrumb-item active"> <a href="{{ route('invoice.update', $invoice) }}"> Update Invoice </a> </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem; margin: auto">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Update Invoice Baru
            </h1>

            <hr class="mt-2 mb-2">

            <form
                method='POST'
                action='{{ route('invoice.update', $invoice) }}'>
                @csrf

                <div class='form-group'>
                    <label for='vendor_id'> Vendor: </label>
                    <select name='vendor_id' id='vendor_id' class='form-control'>
                        @foreach($vendors as $vendor)
                        <option {{ old('vendor_id', $invoice->vendor_id) !== $vendor->id ?: 'selected' }} value='{{ $vendor->id }}'> {{ $vendor->name }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('vendor_id') }}
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-primary btn-sm">
                        Update
                        <i class="fa fa-check"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection