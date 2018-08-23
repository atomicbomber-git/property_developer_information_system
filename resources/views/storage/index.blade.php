@extends('shared.layout')

@section('title', 'All Storages')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> <a href="{{ route('storage.index') }}"> Storage </a> </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-truck"></i>
                Kelola Storage
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('storage.create') }}" class="btn btn-secondary btn-sm">
                    Tambahkan Storage Baru
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Nama Storage </th>
                        <th> Alamat </th>
                        <th> Kendali </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($storages as $storage)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $storage->name }} </td>
                        <td> {{ $storage->address }} </td>
                        <td>
                            <a href="{{ route('storage.update', $storage) }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <form method="POST" class="d-inline-block" action="{{ route('storage.delete', $storage) }}">
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
        </div>
    </div>
</div>
@endsection