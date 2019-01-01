@extends('layouts.app')

@section('content')
<product-view :product="{{ $product }}" inline-template>
<div class="container-fluid">
    <h2>Product Details</h2>
    <div class="row">
        <div class="col-md-8">
            {{-- Editing the product--}}
            <div class="card" style="width: 18rem;" v-if="editing">
                <div class="card-body">
                    <input type="text" class="form-control" v-model="form.name" class="card-title" value="{{ $product->name }}" />
                    <br/>
                    <textarea class="form-control" v-model="form.description" class="card-text">{{ $product->description }}</textarea>
                    <br/>
                    <div class="level">
                        <input type="text" class="form-control mr-1" v-model="form.price" class="card-title" value="{{ $product->price }}" />
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
            <div class="card" style="width: 18rem;" v-else>
                <div class="card-body">
                    <h5 class="card-title"><span v-text="name"></span></h5>
                    <p class="card-text"><span v-text="description"></span></p>
                    <p class="card-title"><span v-text="price"></span>€/Kg</p>
                    <div class="level">
                        <form action="{{ $product->path() }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <button class="ml-a btn btn-primary mr-1 ml-a" @click="editing = true">Edit</button>
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