@forelse ($group_orders as $group_order)
<div class="card">
    <div class="card-body">
        <div class="level">
            <h5 class="card-title"><a href="{{ $group_order->path() }}">Order of {{ \Carbon\Carbon::parse($group_order->open_date)->toFormattedDateString() }}</a>
                <span class="badge badge-danger text-uppercase">{{ $group_order->cancelled ? 'Cancelled' : ''}}</span>
                <span class="badge badge-success text-uppercase">{{ $group_order->isActive ? 'Open' : ''}}</span>
                <span class="badge badge-secondary text-uppercase">{{ ! $group_order->isActive && ! $group_order->cancelled ? 'Closed' : '' }}</span>
                <span class="badge badge-success text-uppercase">{{ $group_order->delivered ? 'Delivered' : ''}}</span>
            </h5>
        </div>
        @if ($group_order->cancelled == false)<h6><span class="text-uppercase small"><strong>closing {{ \Carbon\Carbon::parse($group_order->close_date)->diffForHumans() }}</strong></span></h6>@endif
    </div>
</div>

<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse