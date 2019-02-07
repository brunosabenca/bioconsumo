@extends('layouts.app')

@section('content')
<group-order-view :group_order="{{ $group_order }}" inline-template>
<div class="container-fluid">
    <h2>Order Details</h2>
    <group-order-listing-item :group_order="group_order"></group-order-listing-item>
    <a href="/orders" class="btn btn-secondary">Return</a>
</div>
</group-order-view>
@endsection