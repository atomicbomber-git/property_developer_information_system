@extends('shared.layout')

@section('title', "Update Storage $storage->name")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('storage.index') }}"> Storage </a> </li>
            <li class="breadcrumb-item active"> <a href="{{ route('storage.update', $storage) }}"> Update Storage {{ $storage->name }} </a> </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem; margin: auto">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-pencil"></i>
                Update Storage {{ $storage->name }}
            </h1>

            <hr class="mt-2 mb-2">

            <form
                method='POST'
                action='{{ route('storage.update', $storage) }}'>
                @csrf

                <div class='form-group'>
                    <label for='name'> Nama: </label>

                    <input
                        id='name' name='name' type='text'
                        value='{{ old('name', $storage->name) }}'
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
                        >{{ old('address', $storage->address) }}
                    </textarea>

                    <div class='invalid-feedback'>
                        {{ $errors->first('address') }}
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
