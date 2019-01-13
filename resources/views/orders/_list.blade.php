@forelse ($orders as $order)
<div class="card">
    <div class="card-body">
        <div class="level">
            <h5 class="card-title"><a href="/order/{{ $order->id }}">Order</a></h5>
        </div>
    </div>
</div>
<br/>
@empty
    <p>There are no relevant results at this time.</p>
@endforelse