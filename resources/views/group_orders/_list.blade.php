@forelse ($orders as $order)
<div class="card">
    <div class="card-body">
        <div class="level">
            <h5 class="card-title"><a href="{{ $order->path() }}">{{ $order->name() }}</a> <span class="text-danger text-uppercase small">{{ $order->cancelled == true ? 'Cancelled' : ''}}</span></h5>
        </div>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse