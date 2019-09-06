@extends('shared.layout')

@section('title', 'Create New Item')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('item.index') }}"> Item (From Vendor) </a> </li>
            <li class="breadcrumb-item active"> Add Item </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 35rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Add Item
            </h1>

            <hr class="mt-2 mb-2">

            <div id="app">
                <item-create
                    submit_url='{{ route('item.store') }}'
                    redirect_url='{{ route('item.index') }}'
                    :vendors='{{ json_encode($vendors) }}'
                    :categories='{{ json_encode($categories) }}'
                >
                </item-create>
            </div>
        </div>
    </div>
</div>
@endsection
