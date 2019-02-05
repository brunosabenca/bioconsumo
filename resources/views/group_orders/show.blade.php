@extends('layouts.app')

@section('content')
<order-view :order="{{ $order }}" inline-template>
<div class="container-fluid">
    <h2>Order Details</h2>
    <div class="row">
        <div class="col-md-12">
            {{-- Editing the order --}}
            <div class="card" v-if="editing">
                <div class="card-body">
                    <div class="form-group">
                        <label for="open-date">Open Date</label>
                        <input class="date form-control"  v-model="form.open_date" id="open-date" type="date" name="open-date"
                            value="{{ \Carbon\Carbon::parse($order->open_date)->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="close-date">Close Date</label>
                        <input class="date form-control" v-model="form.close_date"  id="close-date" type="date" name="close-date" 
                            value="{{ \Carbon\Carbon::parse($order->close_date)->format('Y-m-d') }}">
                    </div>
                    <button class="btn btn-secondary btn-xs" @click="editing = true" v-show="! editing">Edit</button>
                    <br/>
                    <div class="level">
                        <button class="ml-a btn btn-secondary mr-1" @click="resetForm">Cancel</button>
                        <button class="btn btn-primary" @click="update">Update</button>
                    </div>
                </div>
            </div>
            {{-- Viewing the order--}}
            <div class="card" v-else>
                <div class="card-body row">
                    <div class="col-md-3">
                        <h5 class="card-title">Order of {{ \Carbon\Carbon::parse($order->open_date)->toFormattedDateString() }}
                            <div v-cloak>
                                <span class="badge badge-danger text-uppercase" v-show="cancelled">Cancelled</span>
                                <span class="badge badge-success text-uppercase" v-show="is_active">Open</span>
                                <span class="badge badge-secondary text-uppercase" v-show="! is_active && ! cancelled">Closed</span>
                            </div>
                        </h5>
                        <h6><span class="text-uppercase small"><strong>closing {{ \Carbon\Carbon::parse($order->close_date)->diffForHumans() }}</strong></span></h6>
                        @can('edit group orders')
                        <div class="level" v-show="! cancelled">
                            <form action="{{ $order->path() }}" method="POST" class="mr-1">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger btn-sm">Cancel</button>
                            </form>
                            <button class="btn btn-primary btn-sm mr-1" @click="editing = true">Edit</button>
                        </div>
                        @endcan
                    </div>
                    <div class="col-md-8">
                        <h6>Active Sellers:</h6>
                        <ul>
                            <li v-for="seller in order.sellers" v-text="seller.name"></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br/>
    <a href="/orders" class="btn btn-secondary">Return</a>
</div>
</order-view>
@endsection