@extends('layouts.app')

@section('content')
<product-listing-view :products="{{ $products }}" inline-template>

<div class="container-fluid">
    <h2>Products</h2>

    <div class="row" v-for="chunk in chunks">
        <div class="col-md-4" v-for="product in chunk" :key="product.id">
            <product-listing-item :product="product" v-on:deleted="removeProduct(product)"></product-listing-item>
            <br/>
        </div>
    </div>
</div>
</product-listing-view>
@endsection