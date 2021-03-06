@extends('shared.layout')

@section('title', "Giros")

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item active"> Giro </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-money"></i>
                Giro
            </h1>

            <hr class="mt-2 mb-2">

            <div class="text-right mb-5 mt-3">
                <a href="{{ route('giro.create') }}" class="btn btn-secondary btn-sm">
                    Add Giro
                    <i class="fa fa-plus"></i>
                </a>
            </div>

            @include('shared.message-success')

            <div class="table-responsive">
                <table class="table table-sm table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th> # </th>
                            <th> Number </th>
                            <th class="text-right pr-3"> Amount (Rp) </th>
                            <th> Transfer Date </th>
                            <th> Control </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($giros as $giro)
                        <tr>
                            <td> {{ $giros->firstItem() - 1 + $loop->iteration }}. </td>
                            <td> {{ $giro->number }} </td>
                            <td class="text-right pr-3"> @convert_money($giro->amount) </td>
                            <td> {{ optional($giro->transfered_at)->format('d-m-Y') }} </td>
                            <td>
                                <a href="{{ route('giro.update', $giro) }}" class="btn btn-dark btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </a>

                            @if($giro->invoices_count == 0)
                                <form method="POST" class="d-inline-block" action="{{ route('giro.delete', $giro) }}">
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

            <div style="text-align: center">
                {{ $giros->links() }}
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
