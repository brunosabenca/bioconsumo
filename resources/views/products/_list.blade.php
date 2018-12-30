@forelse ($products as $product)
<div class="card" style="width: 18rem;">
    <div class="card-body">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text">{{ $product->description }}</p>
        <a href="/products/{{ $product->id }}" class="btn btn-primary">View</a>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse