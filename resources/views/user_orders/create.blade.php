@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Place order</h4>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
            @if ($group_orders->count() > 0)
            <form method="POST" action="/user/orders">
                {{ csrf_field() }}

                <div class="form-group">
                    <div class="form-group">
                        <label for="group_order">Group Order</label>
                        <select class="form-control" id="group_order" name="group_order">
                        @forelse ($group_orders as $group_order)
                        <option value="{{ $group_order->id }}">Order #{{ $group_order->id }}</option>
                        @empty
                        @endforelse
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>


                @if(count($errors))
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                @endif
            </form>
            @else
                <p>There are no group orders open at this time for you to participate in.</p>
            @endif
        </div>
    </div>
</div>
@endsection