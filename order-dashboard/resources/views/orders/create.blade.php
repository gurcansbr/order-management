@extends('layouts.app')

@section('title', 'Create Order')

@section('content')
    <h1>Create Order</h1>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="products" class="form-label">Products</label>
            <div id="products">
                <div class="input-group mb-3">
                    <select name="products[0][product_id]" class="form-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
                    </select>
                    <input type="number" name="products[0][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                </div>
            </div>
            <button type="button" id="addProduct" class="btn btn-secondary">Add Another Product</button>
        </div>
        <button type="submit" class="btn btn-primary">Create Order</button>
    </form>

    <script>
        document.getElementById('addProduct').addEventListener('click', function() {
            let productCount = document.querySelectorAll('#products .input-group').length;
            let newProduct = `
                <div class="input-group mb-3">
                    <select name="products[${productCount}][product_id]" class="form-select" required>
                        <option value="">Select Product</option>
                        @foreach($products as $product)
            <option value="{{ $product->id }}">{{ $product->name }}</option>
                        @endforeach
            </select>
            <input type="number" name="products[${productCount}][quantity]" class="form-control" placeholder="Quantity" min="1" required>
                </div>`;
            document.getElementById('products').insertAdjacentHTML('beforeend', newProduct);
        });
    </script>
@endsection
