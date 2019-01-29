@forelse ($orders as $order)
<div class="card">
    <div class="card-body">
        <div class="level">
            <h5 class="card-title"><a href="{{ $order->path() }}">Order #{{ $order->id }}</a>
                <span class="badge badge-danger text-uppercase">{{ $order->cancelled ? 'Cancelled' : ''}}</span>
                <span class="badge badge-success text-uppercase">{{ $order->is_active ? 'Open' : ''}}</span>
                <span class="badge badge-secondary text-uppercase">{{ ! $order->is_active && ! $order->cancelled ? 'Closed' : '' }}</span>
                <span class="badge badge-success text-uppercase">{{ $order->delivered ? 'Delivered' : ''}}</span>
        </h5>
        </div>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse