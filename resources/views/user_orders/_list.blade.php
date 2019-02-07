@forelse ($orders as $order)
<div class="col-sm-12 col-md-6 col-lg-4">
    <div class="card m-4">
        <h5 class="d-flex card-body">
            <div class="flex-grow-1">
                <a href="{{ $order->path() }}">Order of {{ \Carbon\Carbon::parse($order->order->open_date)->toFormattedDateString() }} </a>
                <div v-cloak>
                    <span class="badge badge-danger text-uppercase">{{ $order->cancelled ? 'Cancelled' : ''}}</span>
                    <span class="badge badge-success text-uppercase">{{ $order->is_active ? 'Open' : ''}}</span>
                    <span class="badge badge-secondary text-uppercase">{{ ! $order->is_active && ! $order->cancelled ? 'Closed' : '' }}</span>
                    <span class="badge badge-success text-uppercase">{{ $order->delivered ? 'Delivered' : ''}}</span>
                </div>
            </div>
            <span class="small"><span class="text-uppercase small"><strong>closing {{ \Carbon\Carbon::parse($order->order->close_date)->diffForHumans() }}</strong></span></span>
        </h5>
    </div>
</div>
@empty
<div class="col-sm-12 col-md-6 col-lg-4 m-4">
    <p>You don't have any orders.</p>
</div>
@endforelse