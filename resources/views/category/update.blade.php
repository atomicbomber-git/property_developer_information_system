@extends('shared.layout')

@section('title', "Update Category $category->name")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('category.index') }}"> Category </a> </li>
            <li class="breadcrumb-item active"> Update Category '{{ $category->name }}' </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem; margin: auto">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-pencil"></i>
                Update Category '{{ $category->name }}'
            </h1>

            <hr class="mt-2 mb-2">

            <form
                method='POST'
                action='{{ route('category.create') }}'>
                @csrf

                <div class='form-group'>
                    <label for='name'> Nama: </label>
                
                    <input
                        id='name' name='name' type='text'
                        value='{{ old('name', $category->name) }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-primary btn-sm">
                        Update
                        <i class="fa fa-pencil"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection