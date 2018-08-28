@extends('shared.layout')

@section('title', 'Edit Vendor ' . $vendor->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> <a href="{{ route('vendor.index') }}"> Vendor </a> </li>
            <li class="breadcrumb-item active"> Update Vendor '{{ $vendor->name }}' </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-pencil"></i>
                Edit Vendor '{{ $vendor->name }}'
            </h1>

            <hr class="mt-2 mb-2">

            <form
                method='POST'
                action='{{ route('vendor.update', $vendor) }}'>
                @csrf

                <div class='form-group'>
                    <label for='name'> Nama: </label>
                
                    <input
                        id='name' name='name' type='text'
                        value='{{ old('name', $vendor->name) }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='address'> Alamat: </label>
                
                    <textarea
                        id='address' name='address'
                        class='form-control {{ !$errors->has('address') ?: 'is-invalid' }}'
                        col='30' row='6'
                        >{{ old('address', $vendor->address) }}</textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('address') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='contact_person'> Contact Person: </label>
                
                    <input
                        id='contact_person' name='contact_person' type='text'
                        value='{{ old('contact_person', $vendor->contact_person) }}'
                        class='form-control {{ !$errors->has('contact_person') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('contact_person') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='contact_person_phone'> No. Telefon Contact Person: </label>
                
                    <input
                        id='contact_person_phone' name='contact_person_phone' type='phone'
                        value='{{ old('contact_person_phone', $vendor->contact_person_phone) }}'
                        class='form-control {{ !$errors->has('contact_person_phone') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('contact_person_phone') }}
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-primary btn-sm">
                        Perbarui
                        <i class="fa fa-check"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection