@extends('layouts.app')

@section('content')
<group-order-view :group_order="{{ $group_order }}" inline-template>
<div class="container-fluid">
    <div class="row px-4">
        <div class="col-12">
            <h2>Order Details</h2>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <group-order-listing-item :group_order="group_order" class="m-4"></group-order-listing-item>
        </div>
    </div>

    <div class="row px-4">
        <div class="col-md-4">
            <a href="/orders" class="btn btn-secondary" data-toggle="tooltip" title="Back to group order listing">Back</a>
        </div>
    </div>
</div>
</group-order-view>
@endsection