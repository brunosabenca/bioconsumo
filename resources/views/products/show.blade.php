@extends('layouts.app')

@section('content')
<h2>Product Details</h2>
<div class="row">
    <div class="col-md-8">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ $product->description }}</p>
        </div>
    </div>
    <br />
    <a href="/products" class="btn btn-primary">Back to Products</a>
</div>

@endsection
