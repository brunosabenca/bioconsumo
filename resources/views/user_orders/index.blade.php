@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>My Orders</h2>
    <div class="row">
        <div class="col-md-12">
            @include('user_orders._list')

            {{ $orders->render() }}
        </div>
    </div>
</div>
@endsection