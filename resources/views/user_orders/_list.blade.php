@forelse ($orders as $order)
<div class="card">
    <div class="card-body">
        <div class="level">
            <h5 class="card-title"><a href="{{ $order->path() }}">Order #{{ $order->id }}</a>
                <span class="badge badge-danger text-uppercase">{{ $order->cancelled == true ? 'Cancelled' : ''}}</span>
                <span class="badge badge-success text-uppercase">{{ $order->delivered == true ? 'Delivered' : ''}}</span>
        </h5>
        </div>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse