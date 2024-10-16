@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
    <h1>Order Details (Order ID: {{ $order->id }})</h1>

    <p><strong>Created At:</strong> {{ $order->created_at }}</p>

    <h3>Products</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Product Name</th>
            <th>Quantity</th>
        </tr>
        </thead>
        <tbody>
        @foreach($order->orderItems as $orderItem)
            <tr>
                <td>{{ $orderItem->product->name }}</td>
                <td>{{ $orderItem->quantity }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <a href="{{ route('orders.index') }}" class="btn btn-primary">Back to Orders</a>
@endsection
