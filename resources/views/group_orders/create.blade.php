@extends('layouts.app')

@section('content')
<new-group-order-view :sellers="{{ $sellers }}"></new-group-order-view>
@endsection