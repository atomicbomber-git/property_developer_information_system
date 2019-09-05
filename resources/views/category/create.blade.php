@extends('shared.layout')

@section('title', 'Create New Category')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('category.index') }}"> Category </a> </li>
            <li class="breadcrumb-item active"> Add Category </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Add Category
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
                        value='{{ old('name') }}'
                        class='form-control {{ !$errors->has('name') ?: 'is-invalid' }}'>

                    <div class='invalid-feedback'>
                        {{ $errors->first('name') }}
                    </div>
                </div>

                <div class="text-right mt-3">
                    <button class="btn btn-primary btn-sm">
                        Add
                        <i class="fa fa-plus"></i>
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection
