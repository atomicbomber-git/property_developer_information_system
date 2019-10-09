@extends('shared.layout')

@section('title', 'Edit Item')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('item.index') }}"> Item </a> </li>
            <li class="breadcrumb-item active"> Edit Item </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 35rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-pencil"></i>
                Edit Item
            </h1>

            <hr class="mt-2 mb-2">

            @include('shared.message-success')

            <div >
                <item-edit
                    submit_url='{{ route('item.update', $item) }}'
                    redirect_url='{{ route('item.edit', $item) }}'
                    :item='{{ json_encode($item) }}'
                    :vendors='{{ json_encode($vendors) }}'
                    :categories='{{ json_encode($categories) }}'
                >
                </item-edit>
            </div>
        </div>
    </div>
</div>
@endsection
