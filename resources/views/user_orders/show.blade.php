@extends('layouts.app')

@section('content')
@if ($group_order)
<div class="level">
<h2>User Order</h2>
<span class="badge badge-secondary small">Group Order #{{ $group_order->id }}</span>
</div>
<div class="row">
    <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
        <form method="POST" action="/user/orders">
            {{ csrf_field() }}

            @if(count($errors))
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </form>
    </div>
</div>
@else
<h2>Place Order</h2>
<p>There is no active group order at this time.</p>
@endif
@endsection