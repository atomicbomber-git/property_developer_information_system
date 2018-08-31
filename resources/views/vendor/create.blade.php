@extends('shared.layout')

@section('title', 'Create New Vendor')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> <a href="{{ route('vendor.index') }}"> Vendor </a> </li>
            <li class="breadcrumb-item active"> Tambahkan Vendor Baru </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem">
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
                        >{{ old('address') }}</textarea>

                    <div class='invalid-feedback'>
                        {{ $errors->first('address') }}
                    </div>
                </div>

                <div class="form-group">
                    <label> Contact Persons: </label>

                    @if(old('contact_people'))
                        @foreach(old('contact_people') as $key => $old_contact_person)
                            <div class="input-row form-row mt-2" data-key="{{ $key }}">
                                <div class="col">
                                    <input
                                        value="{{ $old_contact_person['name'] }}"
                                        type="text" name="contact_people[{{ $key }}][name]"
                                        placeholder="Name" class="input-name form-control form-control-sm {{ $errors->first("contact_people.$key.name", "is-invalid") }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first("contact_people.$key.name") }}
                                        </div>
                                </div>
                                <div class="col">
                                    <input
                                        value="{{ $old_contact_person['phone'] }}" 
                                        type="text"
                                        name="contact_people[{{ $key }}][phone]" placeholder="Phone number"
                                        class="input-phone form-control form-control-sm {{ $errors->first("contact_people.$key.phone", "is-invalid") }}">
                                        <div class="invalid-feedback">
                                            {{ $errors->first("contact_people.$key.phone") }}
                                        </div>
                                </div>
                                <div class="col-1">
                                    <button type="button" class="btn-remove-input btn btn-outline-danger btn-sm d-none">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="input-row form-row mt-2" data-key="1">
                            <div class="col">
                                <input type="text" name="contact_people[1][name]" placeholder="Name" class="input-name form-control form-control-sm">
                            </div>
                            <div class="col">
                                <input type="text" name="contact_people[1][phone]" placeholder="Phone number" class="input-phone form-control form-control-sm">
                            </div>
                            <div class="col-1">
                                <button type="button" class="btn-remove-input btn btn-outline-danger btn-sm d-none">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- For cloning purposes --}}
                <div id="input-template" class="form-row mt-2 d-none">
                    <div class="col">
                        <input type="text" placeholder="Name" class="input-name form-control form-control-sm">
                    </div>
                    <div class="col">
                        <input type="text" placeholder="Phone number" class="input-phone form-control form-control-sm">
                    </div>
                    <div class="col-1">
                        <button type="button" class="btn-remove-input btn btn-outline-danger btn-sm d-none">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="text-right">
                    <button id="btn-add-input" type="button" class="btn btn-sm">
                        <i class="fa fa-plus"></i>
                    </button>
                </div>

                <script>

                    $(document).ready(() => {
                        let input_rows_count = $('.input-row').length;

                        $('.input-row').each((i, elem) => {
                            $(elem).find('.btn-remove-input').click(() => {
                                $(elem).remove();

                                if ($('.input-row').length < 2) {
                                    $('.input-row').last().find('.btn-remove-input').addClass("d-none");
                                }
                            });

                            if (input_rows_count > 1) {
                                $(elem).find('.btn-remove-input').removeClass("d-none");
                            }

                        });

                        $('#btn-add-input').click(() => {
                            let $clone = $('#input-template')
                                .clone()
                                .removeClass("d-none")
                                .addClass("input-row");
                            
                            let key = $('.input-row').last().data('key');
                            $clone.data('key', key+1)
                            $clone.find('.input-name').attr('name', `contact_people[${key+1}][name]`).val("");
                            $clone.find('.input-phone').attr('name', `contact_people[${key+1}][phone]`).val("");

                            $clone.find('.btn-remove-input').click(() => {
                                $clone.remove();

                                if ($('.input-row').length < 2) {
                                    $('.input-row').last().find('.btn-remove-input').addClass("d-none");
                                }
                            });

                            $clone.insertAfter($('.input-row').last());

                            if ($('.input-row').length > 1) {
                                $('.input-row').find('.btn-remove-input').removeClass("d-none");
                            }
                        });

                    });
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