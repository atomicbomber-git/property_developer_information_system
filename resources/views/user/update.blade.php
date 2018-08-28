@extends('shared.layout')

@section('title', "Update User '$user->name'")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('user.index') }}"> User </a> </li>
            <li class="breadcrumb-item active"> Update User '{{ $user->name }}' </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Update User {{ $user->name }}
            </h1>

            <hr class="mt-2 mb-2">

            <form
                method='POST'
                action='{{ route('user.update', $user) }}'>
                @csrf

                <div class='form-group'>
                    <label for='name'> Name: </label>
                
                    <input
                        id='name' name='name' type='text'
                        value='{{ old('name', $user->name) }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='username'> Username: </label>
                
                    <input
                        id='username' name='username' type='text'
                        value='{{ old('username', $user->username) }}'
                        class='form-control {{ !$errors->has('username') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('username') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='privilege'> Hak Akses: </label>
                    <select name='privilege' id='privilege' class='form-control'>
                        @foreach(\App\User::privileges as $privilege)
                        <option {{ old('privilege', $user->privilege) !== $privilege ?: 'selected' }} value='{{ $privilege }}'> {{ $privilege }} </option>
                        @endforeach
                    </select>
                    <div class='invalid-feedback'>
                        {{ $errors->first('privilege') }}
                    </div>
                </div>

                <div class="alert alert-warning">
                    Biarkan kolom dibawah kosong jika Anda tidak
                    ingin mengubah password
                </div>

                <div class='form-group'>
                    <label for='password'> Password: </label>
                
                    <input
                        id='password' name='password' type='password'
                        value='{{ old('password') }}'
                        class='form-control {{ !$errors->has('password') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('password') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='password_confirmation'> Ulangi Password: </label>

                    <input
                        id='password_confirmation' name='password_confirmation' type='password'
                        value='{{ old('password_confirmation') }}'
                        class='form-control {{ !$errors->has('password_confirmation') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('password_confirmation') }}
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