@extends('layouts.app')

@section('content')
<new-product-view :sellers="{{ $sellers }}" inline-template>
<div class="container-fluid">
    <h2>Create new product</h4>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
            <div class="alert alert-success" v-if="submitted" v-cloak>
                Product successfully created!
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Potatoes" maxlength="80" v-model="form.name"
                    :class="errors.name ? 'is-invalid' : ''">
                <form-error v-if="errors.name" :errors="errors">
                    @{{ errors.name[0] }}
                </form-error>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" name="description"
                    placeholder="The best potatoes in the city" rows="3" maxlength="255" v-model="form.description"
                    :class="errors.description ? 'is-invalid' : ''">
                </textarea>
                <form-error v-if="errors.description" :errors="errors">
                    @{{ errors.description[0] }}
                </form-error>
            </div>

            <div class="form-group">
                <label for="price">Price</label>

                <money class="form-control" v-model="form.price" v-bind="money" name="price"
                    :class="errors.price ? 'is-invalid' : ''"></money>

                <form-error v-if="errors.price" :errors="errors">
                    @{{ errors.price[0] }}
                </form-error>
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="text" class="form-control" id="stock" name="stock" placeholder="100" maxlength="4" v-model="form.stock"
                    :class="errors.stock ? 'is-invalid' : ''">
                <form-error v-if="errors.stock" :errors="errors">
                    @{{ errors.stock[0] }}
                </form-error>
            </div>

            <div class="form-group" v-if="authorize('can','edit any product')">
                <label for="user_id">Seller</label>
                <select class="form-control" id="user_id" name="user_id" v-model="form.user_id"
                    :class="errors.user_id ? 'is-invalid' : ''">
                    <option v-for="seller in sellers" :value="seller.id" v-text="seller.name"></option>
                </select>
                <form-error v-if="errors.user_id" :errors="errors">
                    @{{ errors.user_id[0] }}
                </form-error>
            </div>

            <div class="form-group">
                <a href="/products" role="button" class="btn btn-secondary">Return</a>
                <button type="submit" class="btn btn-primary" @click="postAddNewProduct">Submit</button>
            </div>
        </div>
    </div>
</div>
</new-product-view>
@endsection