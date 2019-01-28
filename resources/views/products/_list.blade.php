@forelse ($products as $product)
<div class="card">
    <div class="card-body">
        <h5 class="card-title">
            <a href="/products/{{ $product->id }}">{{ $product->name }}</a>
            <form class="pull-right" method="POST" action="/cart/add/{{$product->id}}">
                {{ csrf_field() }}
                <button type="submit" class="btn btn-primary btn-xs" aria-label="Add to Cart">
                    <i class="fa fa-cart-plus" aria-hidden="true"></i>
                </button>
            </form>
        </h5>
        <span class="ml-a">{{ $product->price }} €/Kg</span>
        <p class="card-text">{{ $product->description }}</p>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse