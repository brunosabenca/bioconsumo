@extends('layouts.app')

@section('content')
<product-view :product="{{ $product }}" inline-template>
<div class="container-fluid">
    <h2>Product</h2>
    <div class="row">
        <div class="col-md-4">
            <product-listing-item :product="product" :single="true"></product-listing-item>
        </div>
    </div>
    <br/>
    <a href="/products" class="btn btn-secondary">Return</a>
</div>
</product-view>
@endsection