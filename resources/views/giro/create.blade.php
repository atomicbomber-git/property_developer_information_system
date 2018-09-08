@extends('shared.layout')

@section('title', "Create Giro")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('giro.index') }}"> Giros </a> </li>
            <li class="breadcrumb-item active"> Create Giro </li>
        </ol>
    </nav>

    <div class="card" style="width: 25rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-money"></i>
                Create Giro
            </h1>

            <hr class="mt-2 mb-2">

            @include('shared.message-success')
            
            <form method="POST" action="{{ route('giro.create') }}">
                @csrf

                <div class='form-group'>
                    <label for='number'> Number: </label>
                
                    <input
                        placeholder="Number"
                        id='number' name='number' type='text'
                        value='{{ old('number') }}'
                        class='form-control {{ !$errors->has('number') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('number') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='amount'> Amount (Rp): </label>
                
                    <input
                        placeholder="Amount"
                        id='amount' name='amount' type='number'
                        value='{{ old('amount') }}'
                        class='form-control {{ !$errors->has('amount') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('amount') }}
                    </div>
                </div>

                <div class='form-group'>
                    <label for='transfered_at'> Transfer Date: </label>
                
                    <input
                        placeholder="Transfer date"
                        id='transfered_at' name='transfered_at' type='date'
                        value='{{ old('transfered_at') }}'
                        class='form-control {{ !$errors->has('transfered_at') ?: 'is-invalid' }}'>
                
                    <div class='invalid-feedback'>
                        {{ $errors->first('transfered_at') }}
                    </div>
                </div>

                <div class="text-right">
                    <button class="btn btn-primary btn-sm">
                        Create
                        <i class="fa fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection