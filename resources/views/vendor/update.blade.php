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
                            <label for='name'> Name: </label>
                        
                            <input
                                id='name' name='name' type='text'
                                value='{{ old('name', $vendor->name) }}'
                                class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('name') }}
                            </div>
                        </div>
        
                        <div class='form-group'>
                            <label for='address'> Address: </label>
                        
                            <textarea
                                id='address' name='address'
                                class='form-control {{ !$errors->has('address') ?: 'is-invalid' }}'
                                col='30' row='6'
                                >{{ old('address', $vendor->address) }}</textarea>
                        
                            <div class='invalid-feedback'>
                                {{ $errors->first('address') }}
                            </div>
                        </div>

                        <div class="form-group text-right mt-3">
                            <button type="submit" class="btn btn-primary btn-sm">
                                Update
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
        
                    </form>
        
                </div>
            </div>
        </div>

        <div class="col">
            <div class="row">
            <div class="card w-100">
                <div class="card-body">
                    <h1 class="h5">
                        <i class="fa fa-pencil"></i>
                        Update Contact Persons
                    </h1>

                    <hr class="mt-2 mb-2">

                    <form action="{{ route('vendor_contact_person.update', $vendor) }}" method="POST">
                        @csrf
                        <div class="form-group">
                            @forelse ($vendor->contact_people as $contact_person)
                            <input type="hidden" name="contact_people[{{ $contact_person->id }}][id]" value="{{ $contact_person->id }}">
                            <div class="input-group mt-2">
                                
                                <input
                                    type="text"
                                    value="{{ old("contact_people.$contact_person->id.name", $contact_person->name) }}"
                                    name="contact_people[{{ $contact_person->id }}][name]" placeholder="Name"
                                    class="form-control {{ $errors->first("contact_people.$contact_person->id.name", 'is-invalid') }}">

                                <input type="text" value="{{ old("contact_people.$contact_person->id.phone", $contact_person->phone) }}"
                                    name="contact_people[{{ $contact_person->id }}][phone]" placeholder="Phone"
                                    class="form-control {{ $errors->first("contact_people.$contact_person->id.phone", 'is-invalid') }}">

                                <div class="input-group-append">
                                    <button form="form-delete-{{ $contact_person->id }}" class="btn btn-danger">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>

                            </div>
                            <span class="d-block text-danger">
                                {{ $errors->first("contact_people.$contact_person->id.name") }}
                                {{ $errors->first("contact_people.$contact_person->id.phone")  }}
                            </span>

                            @empty
                            <div class="alert alert-info">
                                There's no any contact person at all.
                            </div>
                            @endforelse
                        </div>
                    
                        <div class="form-group text-right">
                            <button class="btn btn-primary btn-sm">
                                Update
                                <i class="fa fa-check"></i>
                            </button>
                        </div>
                    </form>

                    @foreach ($vendor->contact_people as $contact_person)
                    <form id="form-delete-{{ $contact_person->id }}" method="POST" action="{{ route('vendor_contact_person.delete', [$vendor, $contact_person]) }}">
                        @csrf
                    </form>
                    @endforeach

                    <div id="vendor-id" data-vendor-id="{{ $vendor->id }}"></div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="card w-100">
                    <div class="card-body">
                        <h1 class="h5">
                        <i class="fa fa-plus"></i>
                        Add New Contact Persons
                    </h1>
                    <hr class="mt-2 mb-2">
                    <div id="add-contact-persons-form">
                        <AddContactPersonsForm/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection