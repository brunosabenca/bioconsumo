@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row px-4">
        <div class="col">
            <h2>Order History</h2>
        </div>
    </div>
    <div class="row p-4">
        @include('user_orders._list')
    </div>
</div>
@endsection