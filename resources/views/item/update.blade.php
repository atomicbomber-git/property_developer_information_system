@extends('shared.layout')

@section('title', "Update Item '$item->name'")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('category.index') }}"> Category </a> </li>
            <li class="breadcrumb-item"> {{ $category->name }} </li>
            <li class="breadcrumb-item"> <a href="{{ route('item.index', $category) }}"> Items </a> </li>
            <li class="breadcrumb-item active"> Update '{{ $item->name }}' </a> </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Update Item '{{ $item->name }}'
            </h1>

            <hr class="mt-2 mb-2">

            <form
                method='POST'
                action='{{ route('item.update', [$category, $item]) }}'>
                @csrf

                <div class='form-group'>
                    <label for='name'> Nama: </label>

                    <input
                        id='name' name='name' type='text'
                        value='{{ old('name', $item->name) }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='unit'> Satuan: </label>

                    <input
                        id='unit' name='unit' type='text'
                        value='{{ old('unit', $item->unit) }}'
                        class='form-control {{ !$errors->has('unit') ?: 'is-invalid' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('unit') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='vendor_id'> Vendor: </label>
                    <select name='vendor_id' id='vendor_id' class='form-control'>
                        @foreach($vendors as $vendor)
                        <option {{ old('vendor_id', $item->vendor_id) !== $vendor->id ?: 'selected' }} value='{{ $vendor->id }}'> {{ $vendor->name }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('vendor_id') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='note'> Note: </label>

                    <textarea
                        id='note' name='note'
                        class='form-control {{ !$errors->has('note') ?: 'is-invalid' }}'
                        col='30' row='6'
                        >{{ old('note', $item->note) }}
                    </textarea>

                    <div class='invalid-feedback'>
                        {{ $errors->first('note') }}
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
