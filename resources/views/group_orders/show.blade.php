@extends('layouts.app')

@section('content')
<order-view :order="{{ $order }}" inline-template>
<div class="container-fluid">
    <h2>Order Details</h2>
    <div class="row">
        <div class="col-md-8">
            {{-- Editing the order --}}
            <div class="card" style="width: 18rem;" v-if="editing">
                <div class="card-body">
                    <div class="form-group">
                        <label for="open-date">Open Date</label>
                        <input class="date form-control"  v-model="form.open_date" id="open-date" type="date" name="open-date"
                            value="{{ \Carbon\Carbon::parse($order->open_date)->format('Y-m-d') }}">
                    </div>
                    <div class="form-group">
                        <label for="close-date">Close Date</label>
                        <input class="date form-control" v-model="form.close_date" type="date" name="close-date" 
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
            <div class="card" style="width: 18rem;" v-else>
                <div class="card-body">
                    <h5 class="card-title">Order #<span v-text="id"></span></h5>
                    <p class="card-text">Open date: <span v-text="open_date"></span></p>
                    <p class="card-text">Close date: <span v-text="close_date"></span></p>
                    <div class="level">
                        <form action="{{ $order->path() }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <button class="ml-a btn btn-primary mr-1 ml-a" @click="editing = true">Edit</button>
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