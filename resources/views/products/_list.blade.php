@forelse ($products as $product)
<div class="card">
    <div class="card-body">
        <div class="level">
            <h5 class="card-title"><a href="/products/{{ $product->id }}">{{ $product->name }}</a></h5>
            <span class="ml-a">{{ $product->price }} €/Kg</span>
        </div>
        <p class="card-text">{{ $product->description }}</p>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse