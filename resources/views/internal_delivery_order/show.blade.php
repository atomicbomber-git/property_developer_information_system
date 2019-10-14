@extends('shared.layout')

@inject('formatter', 'App\Helpers\Formatter')


@section('title', 'Delivery Order Detail')

@section('content')
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"> <a href="{{ route('dashboard.show') }}"> Dashboard </a> </li>
            <li class="breadcrumb-item"> <a href="{{ route('internal-delivery-order.index') }}"> Delivery Order (Internal) </a> </li>
            <li class="breadcrumb-item active"> Detail </li>
        </ol>
    </nav>

    <div class="card">
        <div class="card-body">
            <h1 class="h5">
                <i class="fa fa-list-alt"></i>
                Delivery Order
            </h1>

            <hr class="mt-2 mb-2">

            <dl>
                <dt> Source: </dt>
                <dd> {{ $delivery_order->source->name }} </dd>
            </dl>

            <dl>
                <dt> Target: </dt>
                <dd> {{ $delivery_order->target->name }} </dd>
            </dl>

            <dl>
                <dt> Sender: </dt>
                <dd> {{ $delivery_order->sender->name }} </dd>
            </dl>

            <dl>
                <dt> Sent At: </dt>
                <dd> {{ $formatter->date($delivery_order->sent_at) }} </dd>
            </dl>

            <dl>
                <dt> Driver: </dt>
                <dd> {{ $delivery_order->driver->name }} </dd>
            </dl>

            <table class="table table-sm table-striped table-bordered">
                <thead class="thead thead-dark">
                    <tr>
                        <th> Item </th>
                        <th class="text-right"> Quantity </th>
                        <th> Unit </th>
                        <th> Origin </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($delivery_order->delivery_order_items as $delivery_order_item)
                    <tr>
                        <td> {{ $delivery_order_item->item->name }} </td>
                        <td class="text-right">
                            {{ $formatter->number($delivery_order_item->quantity) }}
                        </td>
                        <td> {{ $delivery_order_item->item->unit }} </td>
                        <td>
                            {{ $delivery_order_item->item->name }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
