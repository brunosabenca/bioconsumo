@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                @include('products._list')

                {{ $products->render() }}
            </div>
        </div>
    </div>
@endsection