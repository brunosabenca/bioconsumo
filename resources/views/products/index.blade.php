@extends('layouts.app')

@section('content')
<product-listing-view :products="{{ $products }}" inline-template>

<div class="container-fluid">
    <h2>Products
        @can('create products')<a href="/products/create" role="button" class="small" aria-label="Create new product"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>@endcan
    </h2>

    <div class="row" v-for="chunk in chunks">
        <div class="col-md-4" v-for="product in chunk" :key="product.id">
            <product-listing-item :product="product" v-on:deleted="removeProduct(product)"></product-listing-item>
            <br/>
        </div>
    </div>
</div>
</product-listing-view>
@endsection