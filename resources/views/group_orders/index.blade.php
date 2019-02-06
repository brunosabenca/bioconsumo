@extends('layouts.app')

@section('content')
<group-order-listing-view :group_orders="{{ $group_orders }}" inline-template>
<div class="container-fluid">
    <h2>Group Orders
        @can('create group orders')
        <a href="/orders/create" role="button" class="small" aria-label="Create new group order">
            <i class="fa fa-plus-circle" aria-hidden="true"></i>
        </a>
        @endcan
    </h2>
    <group-order-listing-item :group_order="group_order" v-for="group_order in group_orders" class="m-3"></group-order-listing-item>
</div>
</group-order-listing-view>
@endsection