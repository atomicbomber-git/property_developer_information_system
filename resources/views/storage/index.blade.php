@extends('shared.layout')

@section('title', 'Storages')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Storage </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-truck"></i>
                Storage
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('storage.create') }}" class="btn btn-secondary btn-sm">
                    Add Storage
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')
            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Storage </th>
                            <th> Address </th>
                            <th> Control </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($storages as $storage)
                        <tr>
                            <td> {{ $loop->iteration }}. </td>
                            <td> {{ $storage->name }} </td>
                            <td> {{ $storage->address }} </td>
                            <td>
                                <a href="{{ route('storage-stock.index.index', $storage) }}" class="btn btn-dark btn-sm mr-2">
                                    Stocks
                                    <i class="fa fa-list"></i>
                                </a>

                                <a href="{{ route('storage.update', $storage) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>

                                @if($storage->delivery_orders_count == 0)
                                <form method="POST" class="d-inline-block" action="{{ route('storage.delete', $storage) }}">
                                    @csrf
                                    <button class="btn btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @else
                                <button
                                    class="btn btn-danger btn-sm disabled"
                                    data-toggle="tooltip"
                                    title="Data ini tidak dapat dihapus karena masih terdapat item terkait dengan data ini.">
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
<script>
    $(document).ready(() => {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection
