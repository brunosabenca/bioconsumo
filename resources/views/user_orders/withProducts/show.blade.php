@extends('layouts.app')

@section('content')
<user-order-view :user_order="{{ $user_order }}" inline-template>
<div class="container-fluid">
    <div class="row">
    @if ($group_order)
        <div class="col-md-8">
            <h2>Order No. <span v-text="id"></span></h2>
            <h5><span class="text-muted pull-right">Group Order No. {{ $group_order->id }}</span>
                <span class="badge badge-danger text-uppercase" v-show="cancelled">Cancelled</span>
                <span class="badge badge-success text-uppercase" v-show="isOpen">Open</span>
                <span class="badge badge-secondary text-uppercase" v-show="! isOpen && ! cancelled">Closed</span>
                <span class="badge badge-success text-uppercase" v-show="delivered">Delivered</span>
            </h5>

            <cart :cartitems="{{ $items }}" v-bind:open="isOpen"></cart>

            <br/>

            <div v-if="! cancelled">
                <button class="btn btn-danger" @click="cancel" v-show="open" role="button" aria-label="Cancel">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                <button class="btn btn-secondary" @click="close" v-show="isOpen" role="button" aria-label="Close">Close</button>
                <button class="btn btn-success" @click="open" v-show="! isOpen" role="button" aria-label="Open">Open</button>
            </div>
        </div>
        <div class="col-md-4">
            <h2>Products</h2>
            @include('products._sidelist')

            {{ $products->render() }}
        </div>
    @else
        <h2>Place Order</h2>
        <p>There is no active group order at this time.</p>
    @endif
    </div>
</div>
</user-order-view>
@endsection