@extends('layouts.app')

@section('title', 'Order List')

@section('content')
    <h1>Order List</h1>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at }}</td>
                <td>
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-info">View</a>
                    <a href="{{ route('invoices.show', $order->id) }}" class="btn btn-secondary">Show Invoice</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
