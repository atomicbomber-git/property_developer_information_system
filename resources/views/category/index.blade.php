@extends('shared.layout')

@section('title', 'All Categories')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Category </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-folder"></i>
                Kelola Category
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('category.create') }}" class="btn btn-secondary btn-sm">
                    Tambahkan Category Baru
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Nama </th>
                        <th> Control </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($category as $category)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $category->name }} </td>
                        <td>
                            <a href="{{ route('category.update', $category) }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <form method="POST" class="d-inline-block" action="{{ route('category.delete', $category) }}">
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