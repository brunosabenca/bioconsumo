@extends('layouts.app')

@section('content')
<product-view :product="{{ $product }}" inline-template>
<div class="container-fluid">
    <h2>Product Details</h2>
    <div class="row">
        <div class="col-md-12">
            {{-- Editing the product--}}
            <div class="card" v-if="editing">
                <div class="card-body">
                    <input type="text" class="form-control" v-model="form.name" class="card-title" value="{{ $product->name }}" maxlength="80"/>
                    <br/>
                    <textarea class="form-control" v-model="form.description" class="card-text" maxlength="255">{{ $product->description }}</textarea>
                    <br/>
                    <div class="level">
                        <input type="text" class="form-control mr-1" v-model="form.price" class="card-title" value="{{ $product->price }}" maxlength="4"/>
                        <span>€/Kg</span>
                    </div>
                    <button class="btn btn-secondary btn-xs" @click="editing = true" v-show="! editing">Edit</button>
                    <br/>
                    <div class="level">
                        <button class="ml-a btn btn-secondary mr-1" @click="resetForm">Cancel</button>
                        <button class="btn btn-primary" @click="update">Update</button>
                    </div>
                </div>
            </div>
            {{-- Viewing the product--}}
            <div class="card" v-else>
                <div class="card-body">
                    <h5 class="card-title level">
                        <span v-text="name"></span>
                        <span class="ml-a"><span v-text="price"></span>€/Kg</span>
                    </h5>
                    <p class="card-text"><span v-text="description"></span></p>
                    <div class="level">
                        <button class="btn btn-secondary btn-sm" @click="editing = true">Edit</button>
                        <form action="{{ $product->path() }}" method="POST" class="ml-1">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        <form class="ml-a" method="POST" action="/cart/add/{{$product->id}}">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-primary" aria-label="Add to Cart">
                                <i class="fa fa-cart-plus" aria-hidden="true"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <a href="/products" class="btn btn-secondary">Return</a>
</div>
</product-view>
@endsection