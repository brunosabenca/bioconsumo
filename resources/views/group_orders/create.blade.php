@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Create new group order</h4>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
            <form method="POST" action="/orders">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="open-date">Open Date</label>
                    <input class="date form-control"  id="open-date" type="date" name="open-date">

                </div>

                <div class="form-group">
                    <label for="close-date">Close Date</label>
                    <input class="date form-control"  id="close-date" type="date" name="close-date">
                </div>

                <div class="form-group">
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
        </div>
    </div>
</div>
@endsection