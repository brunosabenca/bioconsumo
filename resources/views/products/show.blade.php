@extends('layouts.app')

@section('content')
<product-view :product="{{ $product }}" inline-template>
<div class="container-fluid">
    <h2 class="m-4">Product</h2>
    <div class="row">
        <div class="col-md-4">
            <product-listing-item :product="product" :single="true" class="m-4"></product-listing-item>
        </div>
    </div>
    <a href="/products" class="btn btn-secondary mx-4">Return</a>
</div>
</product-view>
@endsection