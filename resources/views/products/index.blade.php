@extends('layouts.app')

@section('content')
<h2>Products</h2>
<div class="row">
    <div class="col-md-8">
        @include('products._list')

        {{ $products->render() }}
    </div>
</div>
@endsection