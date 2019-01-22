@extends('layouts.app')

@section('content')
<h2>Orders</h2>
<div class="row">
    <div class="col-md-8">
        @include('group_orders._list')

        {{ $orders->render() }}
    </div>
</div>
@endsection