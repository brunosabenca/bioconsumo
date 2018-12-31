@forelse ($products as $product)
<div class="card">
    <div class="card-body">
        <h5 class="card-title"><a href="/products/{{ $product->id }}">{{ $product->name }}</a></h5>
        <p class="card-text">{{ $product->description }}</p>
            <form action="{{ $product->path() }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}

                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse