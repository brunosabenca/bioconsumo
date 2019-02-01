@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Group Orders
        @can('create group order')<a href="/orders/create" role="button" class="small" aria-label="Create new group order"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>@endcan
    </h2>
    <div class="row">
        <div class="col-md-12">
            @include('group_orders._list')

            {{ $orders->render() }}
        </div>
    </div>
</div>
@endsection