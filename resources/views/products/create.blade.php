@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-8">
                <h4>Create new product</h4>
                <form method="POST" action="/products">
                    {{ csrf_field() }}

                    <div class="form-group">
                        <label for="product-name">Name</label>
                        <input type="text" class="form-control" id="product-name" name="product-name" placeholder="Potatoes" >
                    </div>

                    <div class="form-group">
                        <label for="product-description">Description</label>
                        <textarea class="form-control" id="product-description" name="product-description" placeholder="The best potatoes in the city" rows="3" ></textarea>
                    </div>

                    <div class="form-group">
                        <label for="product-name">Price</label>
                        <input type="text" class="form-control" id="product-price" name="product-price" placeholder="5" >
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