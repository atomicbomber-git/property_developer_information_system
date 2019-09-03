@extends('shared.layout')

@section('title', 'Create New Invoice')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('invoice.index') }}"> Invoice </a> </li>
            <li class="breadcrumb-item active"> Tambahkan Invoice Baru </li>
        </ol>
    </nav>

    <div class="card" style="max-width: 40rem">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-plus"></i>
                Tambahkan Invoice Baru
            </h1>

            <hr class="mt-2 mb-2">

            <div id="create-invoice-form">
                <CreateInvoiceForm/>
            </div>

        </div>
    </div>
</div>
@endsection
