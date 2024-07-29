@extends('layouts.admin')
@section('title', __('order.Orders_List'))
@section('content-header', __('Order Detail'))
@section('content-actions')
<a href="{{route('cart.index')}}" class="btn btn-primary">{{ __('cart.title') }}</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-5">
        <h3>Customer: {{ $order->getCustomerName()}}</h3>
        <h4>Order Date: {{ $order->created_at }}</h4>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->price }}</td>
                        <td>{{ $item->price * $item->quantity }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
        <h4>Total Amount: {{ $order->items->sum(fn($item) => $item->price * $item->quantity) }}</h4>
        <h4>Received Amount: {{ $order->payments->sum('amount') }}</h4>
    </div>
    @endsection
