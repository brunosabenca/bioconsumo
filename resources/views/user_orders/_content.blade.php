<h2>Order No. <span v-text="id"></span></h2>
<h5><span class="text-muted pull-right">Group Order No. {{ $group_order->id }}</span>
    <span class="badge badge-danger text-uppercase" v-show="cancelled">Cancelled</span>
    <span class="badge badge-success text-uppercase" v-show="is_active && ! cancelled">Open</span>
    <span class="badge badge-secondary text-uppercase" v-show="! is_active && ! cancelled">Closed</span>
    <span class="badge badge-success text-uppercase" v-show="delivered">Delivered</span>
</h5>

<cart :cartitems="{{ $items }}" :is_active="is_active"></cart>

<br/>