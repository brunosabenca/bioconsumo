@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2 class="m-4">Order History</h2>
    <div class="row">
        @include('user_orders._list')
    </div>
</div>
@endsection