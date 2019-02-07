@extends('layouts.app')

@section('content')
<user-order-view :user_order="{{ $user_order }}" inline-template>
<div class="container-fluid">
    <div class="row">
    @if ($group_order)
        <div class="col mx-4">
            @include('user_orders._content')
        </div>
    @else
        <h2>Place Order</h2>
        <p>There is no active group order at this time.</p>
    @endif
    </div>
</div>
</user-order-view>
@endsection