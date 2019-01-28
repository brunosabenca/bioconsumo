@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Products</h2>
    @include('products._list')

    {{ $products->render() }}
</div>
@endsection