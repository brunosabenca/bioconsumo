@forelse ($orders as $order)
<div class="card">
    <div class="card-body">
        <div class="level v-cloak">
        <h5 class="card-title"><a href="{{ $order->path() }}">Order of {{ \Carbon\Carbon::parse($order->order->open_date)->toFormattedDateString() }} </a>
            <div v-cloak>
                <span class="badge badge-danger text-uppercase">{{ $order->cancelled ? 'Cancelled' : ''}}</span>
                <span class="badge badge-success text-uppercase">{{ $order->is_active ? 'Open' : ''}}</span>
                <span class="badge badge-secondary text-uppercase">{{ ! $order->is_active && ! $order->cancelled ? 'Closed' : '' }}</span>
                <span class="badge badge-success text-uppercase">{{ $order->delivered ? 'Delivered' : ''}}</span>
            </div>
        </h5>
        </div>
        <h6><span class="text-uppercase small"><strong>closing {{ \Carbon\Carbon::parse($order->order->close_date)->diffForHumans() }}</strong></span></h6>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse