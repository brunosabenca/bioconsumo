@forelse ($orders as $order)
<div class="card">
    <div class="card-body">
        <div class="level">
            <h5 class="card-title"><a href="{{ $order->path() }}">{{ $order->name() }}</a>
                <span class="badge badge-danger text-uppercase">{{ $order->cancelled == true ? 'Cancelled' : ''}}</span>
                <span class="badge badge-success text-uppercase">{{ $order->open == true ? 'Open' : ''}}</span>
                <span class="badge badge-secondary text-uppercase">{{ $order->open == false ? 'Closed' : ''}}</span>
        </h5>
        </div>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse