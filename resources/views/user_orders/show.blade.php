@extends('layouts.app')

@section('content')
<user-order-view :user_order="{{ $user_order }}" inline-template>
<div class="container-fluid">
    <h2>Order Details</h2>
    <div class="row">
        @if ($group_order)
        <div class="col-md-8">
            <div class="card" style="width: 24rem">
                <div class="card-body">
                    <div class="level">
                        <h5 class="card-title">Order #<span v-text="id"></span>
                            <span class="badge badge-danger text-uppercase" v-show="cancelled">Cancelled</span>
                            <span class="badge badge-success text-uppercase" v-show="open">Open</span>
                            <span class="badge badge-secondary text-uppercase" v-show="! open && ! cancelled">Closed</span>
                            <span class="badge badge-success text-uppercase" v-show="delivered">Delivered</span>
                        </h5>
                        <span class="badge badge-secondary text-uppercase ml-a">Group Order #{{ $group_order->id }}</span>
                    </div>

                    <cart-view :items="{{ $items }}" inline-template>
                        <ul>
                            <li v-for="item in items">@{{ item.product.name }}</li>
                        </ul>
                    </cart-view>

                    <div class="level" v-show="! cancelled">
                        <form action="{{ $user_order->path() }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">Cancel</button>
                        </form>
                        <button class="ml-a btn btn-secondary" @click="closeOrder" v-show="open">Close</button>
                        <button class="ml-a btn btn-success" @click="openOrder" v-show="! open">Open</button>
                    </div>
                </div>
            </div>
            <br/>
            <a href="/orders" class="btn btn-secondary">Return</a>
        </div>
        @else
        <h2>Place Order</h2>
        <p>There is no active group order at this time.</p>
        @endif
    </div>
</div>
</user-order-view>
@endsection