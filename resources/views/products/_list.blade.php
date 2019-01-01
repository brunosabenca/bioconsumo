@forelse ($products as $product)
<div class="card">
    <div class="card-body">
        <h5 class="card-title"><a href="/products/{{ $product->id }}">{{ $product->name }}</a></h5>
        <p class="card-text">{{ $product->description }}</p>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse