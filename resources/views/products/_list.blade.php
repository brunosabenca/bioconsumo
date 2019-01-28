@foreach ($products->chunk(6) as $products)
<div class="row">
    @forelse ($products as $product)
    <div class="col-md-2">
        <div class="card" style="width: 18rem;">
            <div class="card-body">
                <h5 class="level card-title">
                    <a href="/products/{{ $product->id }}">{{ $product->name }}</a>
                    <span class="ml-a">{{ $product->price }} €/Kg </span>
                </h5>
                <p class="card-text">{{ $product->description }}</p>

                <div class="level">
                    <form class="ml-a" method="POST" action="/cart/add/{{$product->id}}">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-primary btn-xs" aria-label="Add to Cart">
                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
        <br/>
    </div>
    @empty
        <p>There are no relevant results at this time.</p>
    @endforelse
</div>
@endforeach