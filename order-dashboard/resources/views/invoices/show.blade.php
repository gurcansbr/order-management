@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Invoice Details</h2>

        @if($invoice !== null)
        <div class="invoice-details">
            <h4>Invoice ID: {{ $invoice['id'] }}</h4>
            <h4>Order ID: {{ $invoice['order_id'] }}</h4>
            <h4>Total: {{ $invoice['total'] }}</h4>

            <h5>Items:</h5>
            <table class="table">
                <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Base Price</th>
                    <th>Tax</th>
                    <th>Discount</th>
                    <th>Total Price</th>
                    <th>Currency</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($invoice['items'] as $item)
                    <tr>
                        <td>{{ $item['product_name'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>{{ $item['price']['base'] }}</td>
                        <td>{{ $item['price']['tax'] }}</td>
                        <td>{{ $item['price']['discount'] }}</td>
                        <td>{{ $item['price']['base'] + $item['price']['tax'] - $item['price']['discount'] }}</td>
                        <td>{{ $item['price']['currency'] }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        @else
            <h4>Invoice not found</h4>
        @endif
    </div>
@endsection
