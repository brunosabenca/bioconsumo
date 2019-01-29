@extends('layouts.app')

@section('content')
<user-order-view :user_order="{{ $user_order }}" inline-template>
<div class="container-fluid">
    <div class="row">
    @if ($group_order)
        <div class="col-md-8">
            @include('user_orders._content')
        </div>
        @include('user_orders._products')
    @else
        <h2>Place Order</h2>
        <p>There is no active group order at this time.</p>
    @endif
    </div>
</div>
</user-order-view>
@endsection