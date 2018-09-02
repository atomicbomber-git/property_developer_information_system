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

    @include('shared.message-success')

    <div class="row">
        <div class="col-5">
            <div class="card">
                <div class="card-body">
                    <h1 class="h5">
                        <i class="fa fa-pencil"></i>
                        Update Vendor '{{ $vendor->name }}'
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

        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h1 class="h5">
                        <i class="fa fa-pencil"></i>
                        Update Contact Persons
                    </h1>

                    <hr class="mt-2 mb-2">

                    <div class="form-group">
                        @forelse ($vendor->contact_people as $contact_person)
                        <div class="input-group mt-2">
                            <input type="text" value="{{ $contact_person->name }}" name="contact_people[{{ $contact_person->id }}][name]" placeholder="Name" class="form-control">
                            <input type="text" value="{{ $contact_person->phone }}" name="contact_people[{{ $contact_person->id }}][phone]" placeholder="Phone" class="form-control">
                            <div class="input-group-append">
                                <button form="form-delete-{{ $contact_person->id }}" class="btn btn-danger">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                        @empty
                        <div class="alert alert-info">
                            There's no any contact person at all.
                        </div>
                        @endforelse
                    </div>

                    @foreach ($vendor->contact_people as $contact_person)
                    <form id="form-delete-{{ $contact_person->id }}" method="POST" action="{{ route('vendor_contact_person.delete', [$vendor, $contact_person]) }}">
                        @csrf
                    </form>
                    @endforeach

                    <div id="vendor-id" data-vendor-id="{{ $vendor->id }}"></div>

                    <h1 class="h5 mt-5">
                        <i class="fa fa-plus"></i>
                        Add New Contact Persons
                    </h1>

                    <hr/>
                    <div id="add-contact-persons-form">
                        <AddContactPersonsForm/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection