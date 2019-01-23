@forelse ($products as $product)
<div class="card">
    <div class="card-body">
        <div class="level">
            <h5 class="card-title"><a href="/products/{{ $product->id }}">{{ $product->name }}</a></h5>
            <span class="ml-a">{{ $product->price }} €/Kg</span>
        </div>
        <p class="card-text">{{ $product->description }}</p>

        @auth
        <form method="POST" action="/cart/add/{{$product->id}}">
            {{ csrf_field() }}
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Add</button>
            </div>

            @if(count($errors))
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif
        </form>
        @endauth
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse