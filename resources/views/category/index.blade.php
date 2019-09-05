@extends('shared.layout')

@section('title', 'Categories')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Category </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-folder"></i>
                Category
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('category.create') }}" class="btn btn-secondary btn-sm">
                    Add Category
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')
            <div class="table-responsive">
                <table class="datatable table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Nama </th>
                            <th class="text-center"> Controls </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $category->name }} </td>
                            <td class="text-center">
                                <a href="{{ route('category.update', $category) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                @if ($category->items_count == 0)

                                <form method="POST" class="d-inline-block" action="{{ route('category.delete', $category) }}">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>

                                @else

                                <button class="btn btn-danger btn-sm disabled" data-toggle="tooltip" title="Data ini tidak dapat dihapus karena masih terdapat item terkait dengan data ini.">
                                    <i class="fa fa-trash"></i>
                                </button>

                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @parent
    @include('shared.datatables')
@endsection

