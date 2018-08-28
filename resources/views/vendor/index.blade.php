@extends('shared.layout')

@section('title', 'All Vendors')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Vendor </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-shopping-cart"></i>
                Kelola Vendor
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('vendor.create') }}" class="btn btn-secondary btn-sm">
                    Tambahkan Vendor Baru
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <table class="table table-sm table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th> # </th>
                        <th> Nama Vendor </th>
                        <th> Alamat </th>
                        <th> Contact </th>
                        <th> Kendali </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($vendors as $vendor)
                    <tr>
                        <td> {{ $loop->iteration }}. </td>
                        <td> {{ $vendor->name }} </td>
                        <td> {{ $vendor->address }} </td>
                        <td>
                            {{ $vendor->contact_person }}
                            <br>
                            {{ $vendor->contact_person_phone }}
                        </td>
                        <td>
                            <a href="{{ route('vendor.update', $vendor) }}" class="btn btn-dark btn-sm">
                                <i class="fa fa-pencil"></i>
                            </a>

                            @if ($vendor->items_count == 0)

                            <form method="POST" class="d-inline-block" action="{{ route('vendor.delete', $vendor) }}">
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
@endsection

@section('script')
<script>
    $(document).ready(() => {
        $('[data-toggle="tooltip"]').tooltip()
    });
</script>
@endsection