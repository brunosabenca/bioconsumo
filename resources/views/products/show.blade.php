@extends('layouts.app')

@section('content')
<product-view :product="{{ $product }}" inline-template>
<div class="container-fluid">
    <div class="row px-4">
        <div class="col">
            <h2>Product</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3">
            <product-listing-item :product="product" :single="true" class="m-4"></product-listing-item>
        </div>
    </div>
    <div class="row px-4">
        <div class="col">
            <a href="/products" class="btn btn-sm btn-secondary" data-toggle="tooltip" title="Back to product listing">
                <i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Back
            </a>
        </div>
    </div>
</div>
</product-view>
@endsection