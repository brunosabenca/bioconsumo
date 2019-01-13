@extends('layouts.app')

@section('content')
<h2>Create new order</h4>
<div class="row">
    <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
        <form method="POST" action="/orders">
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
@endsection