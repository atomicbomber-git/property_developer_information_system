@inject('formatter', "App\Helpers\Formatter")

@extends('shared.layout')
@section('title', 'Items')
@section('content')
<div class="container my-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Item </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-cubes"></i>
                Item
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('item.create') }}" class="btn btn-secondary btn-sm">
                    Add Item
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <div class='table-responsive'>
                <table class='datatable table table-sm table-bordered table-striped'>
                    <thead class='thead thead-dark'>
                        <tr>
                            <th> # </th>
                            <th style="width: 5rem"> Name </th>
                            <th> Unit </th>
                            <th style="width: 5rem"> Vendors </th>
                            <th> Category </th>
                            <th class="text-right"> Latest Price </th>
                            <th class="text-center" style="width: 10rem"> Controls </th>
                        </tr>
                    </thead>

                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    @parent
    <script>
        $(document).ready(function () {
            $("table.datatable").dataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('item.index') }}',

                columns: [
                    { data: 'DT_RowIndex', name: 'id' },
                    { data: 'name', name: 'name' },
                    { data: 'unit', name: 'unit' },
                    { data: 'vendor_list', name: 'vendors.name'},
                    { data: 'category.name', name: 'category.name'},
                    {
                        data: 'latest_delivery_order_item',
                        name: 'latest_delivery_order_item.price',
                        className: 'text-right',
                        render: window.currencyDataTableRenderer
                    },
                    { data: 'controls', className: 'text-center', orderable: false, searchable: false }
                ],
            })
        })
    </script>
@endsection
