@extends('layouts.app')

@section('content')
<product-view :product="{{ $product }}" inline-template>
<div class="container-fluid">
    <div class="row px-4">
        <div class="col-12">
            <h2>Product</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <product-listing-item :product="product" :single="true" class="m-4"></product-listing-item>
        </div>
    </div>

    <div class="row px-4">
        <div class="col-md-4">
            <a href="/products" class="btn btn-secondary" data-toggle="tooltip" title="Back to product listing">Back</a>
        </div>
    </div>
</div>
</product-view>
@endsection