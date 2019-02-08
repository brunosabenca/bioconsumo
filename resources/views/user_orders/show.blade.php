@extends('layouts.app')

@section('content')
<user-order-view :user_order="{{ $user_order }}" inline-template>
<div class="container-fluid">

    <div class="row px-4">
    @if ($group_order)
        <div class="col">
            <h2>Order of {{ \Carbon\Carbon::parse($user_order->order->open_date)->toFormattedDateString() }}</h2>

            <h5><span class="text-muted pull-right">Group Order No. {{ $group_order->id }}</span>
            <div v-cloak>
                <span class="badge badge-danger text-uppercase" v-show="cancelled">Cancelled</span>
                <span class="badge badge-success text-uppercase" v-show="is_active && ! cancelled">Open</span>
                <span class="badge badge-secondary text-uppercase" v-show="! is_active && ! cancelled">Closed</span>
                <span class="badge badge-success text-uppercase" v-show="delivered">Delivered</span>
            </div>
            </h5>

            <cart :user_order_id="id" :cartitems="{{ $items }}" :is_active="is_active"></cart>
        </div>
    @else
        <div class="col">
            <h2>Place Order</h2>
            <p>There is no active group order at this time.</p>
        </div>
    @endif
    </div>

</div>
</user-order-view>
@endsection