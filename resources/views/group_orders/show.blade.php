@extends('layouts.app')

@section('content')
<group-order-view :group_order="{{ $group_order }}" inline-template>
<div class="container-fluid">
    <h2 class="m-4">Order Details</h2>
    <div class="row">
        <div class="col-md-4">
            <group-order-listing-item :group_order="group_order" class="m-4"></group-order-listing-item>
        </div>
    </div>
    <a href="/orders" class="btn btn-secondary mx-4">Return</a>
</div>
</group-order-view>
@endsection