@extends('layouts.app')

@section('content')
<product-listing-view :products="{{ $products }}" :sellers="{{ $sellers }}" inline-template>

<div class="container-fluid">
    <h2>Products
        @can('create products')<a href="/products/create" role="button" class="small" aria-label="Create new product"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>@endcan
    </h2>

    <div class="form-row mt-2">
        <label for="seller" class="form-label col-auto">Seller</label>
        <select name="seller" class="form-control form-control-sm col-md-2" v-model="seller_id" selected="">
            <option :value="null">All Sellers</option>
            <option v-for="seller in sellers" :value="seller.id">@{{seller.name}}</option>
        </select>
    </div>

    <div class="row mt-2" v-for="chunk in filteredChunks">
        <div class="col-md-4" v-for="product in chunk" :key="product.id">
            <product-listing-item :product="product" v-on:deleted="removeProduct(product)"></product-listing-item>
            <br/>
        </div>
    </div>
</div>
</product-listing-view>
@endsection