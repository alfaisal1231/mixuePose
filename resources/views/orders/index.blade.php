@extends('layouts.admin')

@section('title', __('order.Orders_List'))
@section('content-header', __('order.Orders_List'))
@section('content-actions')
    <a href="{{route('cart.index')}}" class="btn btn-primary">{{ __('cart.title') }}</a>
@endsection

@section('content')
<div class="card">
    <div class="card-body">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form action="{{ route('orders.index') }}" method="GET">
                    <div class="row align-items-end mb-3">
                        <div class="col-md-3 mb-2 mb-md-0">
                            <a href="{{ route('order.pdf') }}" class="btn btn-primary btn-block">Export All</a>
                        </div>
                        <div class="col-md-6 mb-2 mb-md-0">
                            <a href="{{ route('order.pdf', ['start_date' => request('start_date'), 'end_date' => request('end_date')]) }}" class="btn btn-primary btn-block">Export Filtered Orders</a>
                        </div>
                    </div>
                    <div class="row align-items-end mb-3">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label for="start_date" class="form-label">Start Date</label>
                            <input type="date" id="start_date" name="start_date" class="form-control" value="{{ request('start_date') }}">
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label for="end_date" class="form-label">End Date</label>
                            <input type="date" id="end_date" name="end_date" class="form-control" value="{{ request('end_date') }}">
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <button class="btn btn-outline-primary btn-block" type="submit">{{ __('order.submit') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        
        </div>
        <table class="table">
            <thead>
                <tr>
                    <th>{{ __('order.ID') }}</th>
                    <th>{{ __('order.Customer_Name') }}</th>
                    <th>{{ __('order.Total') }}</th>
                    <th>{{ __('order.Received_Amount') }}</th>
                    {{-- <th>{{ __('order.Status') }}</th> --}}
                    <th>{{ __('order.To_Pay') }}</th>
                    <th>{{ __('order.Created_At') }}</th>
                    <th>{{ 'Actions' }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                <tr>
                    <td>{{$order->id}}</td>
                    <td>{{$order->getCustomerName()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedTotal()}}</td>
                    <td>{{ config('settings.currency_symbol') }} {{$order->formattedReceivedAmount()}}</td>
                    <td>
                        @if($order->receivedAmount() == 0)
                            <span class="badge badge-danger">{{ __('order.Not_Paid') }}</span>
                        @elseif($order->receivedAmount() < $order->total())
                            <span class="badge badge-warning">{{ __('order.Partial') }}</span>
                        @elseif($order->receivedAmount() == $order->total())
                            <span class="badge badge-success">{{ __('order.Paid') }}</span>
                        @elseif($order->receivedAmount() > $order->total())
                            <span class="badge badge-info">{{ __('order.Change') }}</span>
                        @endif
                    </td>
                    <td>{{config('settings.currency_symbol')}} {{number_format($order->total() - $order->receivedAmount(), 2)}}</td>
                    <td>{{$order->created_at}}</td>
                    <td>
                        <a href="{{ route('order.details', $order->id) }}" class="btn btn-primary">View Details</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th>{{ config('settings.currency_symbol') }} {{ number_format($total, 2) }}</th>
                    <th>{{ config('settings.currency_symbol') }} {{ number_format($receivedAmount, 2) }}</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
        {{ $orders->render() }}
    </div>
</div>
@endsection

