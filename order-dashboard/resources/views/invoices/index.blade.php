@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Invoices</h2>
        @if($invoices)
            <table class="table">
                <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Order ID</th>
                    <th>Total</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice['id'] }}</td>
                        <td>{{ $invoice['order_id'] }}</td>
                        <td>{{ $invoice['total'] }}</td>
                        <td>
                            <a href="{{ route('invoices.show', $invoice['order_id']) }}" class="btn btn-primary">View Details</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <p>No invoices found.</p>
        @endif
    </div>
@endsection
