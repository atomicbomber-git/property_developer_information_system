@extends('shared.layout')

@section('title', 'Create New Vendor')

@section('content')
<div class="container">
    <div class="card" style="max-width: 25rem; margin: auto">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Tambahkan Vendor Baru
            </h1>

            <hr class="mt-2 mb-2">

            <form
                method='POST'
                action='{{ route('vendor.create') }}'>
                @csrf

                <div class='form-group'>
                    <label for='name'> Nama: </label>
                
                    <input
                        id='name' name='name' type='text'
                        value='{{ old('name') }}'
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
                        >
                        {{ old('address') }}
                    </textarea>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('address') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='contact_person'> Contact Person: </label>
                
                    <input
                        id='contact_person' name='contact_person' type='text'
                        value='{{ old('contact_person') }}'
                        class='form-control {{ !$errors->has('contact_person') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('contact_person') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='contact_person_phone'> No. Telefon Contact Person: </label>
                
                    <input
                        id='contact_person_phone' name='contact_person_phone' type='phone'
                        value='{{ old('contact_person_phone') }}'
                        class='form-control {{ !$errors->has('contact_person_phone') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('contact_person_phone') }}
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