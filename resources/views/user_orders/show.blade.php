@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Order Details</h2>
    <div class="card">
        <div class="card-body">
            @if ($group_order)
            <h5 class="card-title">User Order #{{ $user_order->id }}</h5>
            <p class="level">
                <span class="badge badge-danger text-uppercase">{{ $user_order->cancelled == true ? 'Cancelled' : ''}}</span>
                <span class="badge badge-success text-uppercase">{{ $user_order->delivered == true ? 'Delivered' : ''}}</span>
                <span class="badge badge-secondary text-uppercase">Group Order #{{ $group_order->id }}</span>
            <p>
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

                    @if ($user_order->cancelled == false) 
                    <form action="{{ $user_order->path() }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger">Cancel</button>
                    </form>
                    @endif
                </div>
            </div>
            @else
            <h2>Place Order</h2>
            <p>There is no active group order at this time.</p>
            @endif
        </div>
    </div>
    <br/>
    <a href="{{ URL::previous() }}" class="btn btn-secondary">Return</a>
</div>
@endsection