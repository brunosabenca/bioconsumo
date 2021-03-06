@extends('layouts.app')

@section('content')
<product-listing-view :products="{{ $products }}" :sellers="{{ $sellers }}" inline-template>

<div class="container-fluid">
    <div class="row px-4">
        <div class="col">
            <h2>Products
                @can('create products')
                <a href="#"  @click="creating ? creating = false : creating = true"
                    role="button" class="small" aria-label="Create new product"
                    data-toggle="tooltip" title="Create new product">
                    <i v-show="creating" class="fa fa-minus-square" aria-hidden="true" v-cloak></i>
                    <i v-show="!creating" class="fa fa-plus-square" aria-hidden="true" v-cloak></i>
                </a>
                @endcan
            </h2>
        </div>
    </div>

    <div v-show="creating" class="form-group row px-4" v-cloak>
        <div class="col">
            <new-product-view :sellers="{{ $sellers }}" inline-template
                v-on:creation-cancelled="creating = false"
                v-on:creation-success="addProduct">
                <div class="card">
                    <h6 class="card-header">Create new product</h6>
                    <div class="card-body">
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
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-secondary btn-sm" @click="cancelCreation" v-scroll-to="'#app'"
                            data-toggle="tooltip" title="Cancel changes">
                            <i class="fa fa-times-circle" aria-hidden="true"></i>
                            Cancel</button>
                        <button class="btn btn-primary btn-sm" @click="postAddNewProduct"
                            data-toggle="tooltip" title="Save changes">
                            <i class="fa fa-save" aria-hidden="true"></i>
                            Save</button>
                    </div>
                </div>
            </new-product-view>
        </div>
    </div>

    <div class="row px-4">
        <div class="form-group col-sm-5 col-md-4 col-lg-3 mr-3">
            <label for="search" class="form-label mr-1 sr-only">Search</label>
            <vue-fuse name="search" placeholder="Search" class="form-control form-control-sm" 
                :keys="keys" :list="items" :default-all="true" event-name="results"
                data-toggle="tooltip" title="Search for products">
            </vue-fuse>
        </div>

        <div class="form-group col-sm-4 col-md-3 col-lg-2 ml-a mr-3">
            <label for="seller" class="form-label mr-1 sr-only" v-if="sellers.length > 1">Filter</label>
            <select name="seller" class="form-control form-control-sm" v-model="seller_id" selected="" v-if="sellers.length > 1"
                data-toggle="tooltip" title="Filter results by seller">
                <option :value="null">All Sellers</option>
                <option v-for="seller in sellers" :value="seller.id">@{{seller.name}}</option>
            </select>
        </div>
    </div>

    <div class="row px-4">
        <div class="col-sm-12 col-md-6 col-lg-4 col-xl-3" v-for="product in filteredItems(items, seller_id)" :key="product.id">
            <product-listing-item class="pr-3 pb-5" :product="product" v-on:deleted="removeProduct(product)"></product-listing-item>
        </div>
    </div>
</div>
</product-listing-view>
@endsection