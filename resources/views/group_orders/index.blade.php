@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Group Orders</h2>
    <div class="row">
        <div class="col-md-8">
            @include('group_orders._list')

            {{ $orders->render() }}
        </div>
    </div>
</div>
@endsection