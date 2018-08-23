@extends('shared.layout')

@section('title', 'All Items')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> <a href="{{ route('item.index') }}"> Item </a> </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-list"></i>
                Kelola Item
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('item.create') }}" class="btn btn-secondary btn-sm">
                    Tambahkan Item Baru
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Nama Item </th>
                        <th> Unit </th>
                        <th> Vendor </th>
                        <th> Kendali </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($items as $item)
                    <tr>
                        <td> {{ $items->firstItem() - 1 + $loop->iteration }}. </td>
                        <td> {{ $item->name }} </td>
                        <td> {{ $item->unit }} </td>
                        <td> {{ $item->vendor->name }} </td>
                        <td>
                            <a href="{{ route('item.update', $item) }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <form method="POST" class="d-inline-block" action="{{ route('item.delete', $item) }}">
                                @csrf
                                <button class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="text-align: center">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection