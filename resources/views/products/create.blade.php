@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h2>Create new product</h4>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
            <form method="POST" action="/products">
                {{ csrf_field() }}

                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Potatoes" maxlength="80">
                </div>

                <div class="form-group">
                    <label for="product-description">Description</label>
                    <textarea class="form-control" id="description" name="description" placeholder="The best potatoes in the city" rows="3" maxlength="255"></textarea>
                </div>

                <div class="form-group">
                    <label for="product-name">Price</label>
                    <input type="text" class="form-control" id="price" name="price" placeholder="5" maxlength="4">
                </div>

                <div class="form-group">
                    <label for="product-name">Stock</label>
                    <input type="text" class="form-control" id="stock" name="stock" placeholder="100" maxlength="4">
                </div>

                <div class="form-group">
                    <label for="seller">Seller</label>
                    <select class="form-control" id="seller" name="seller_id">
                    @forelse ($sellers as $seller)
                    <option value="{{ $seller->id }}">{{ $seller->name }}</option>
                    @empty
                    @endforelse
                    </select>
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