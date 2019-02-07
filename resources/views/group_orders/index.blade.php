@extends('layouts.app')

@section('content')
<group-order-listing-view :group_orders="{{ $group_orders }}" inline-template>
<div class="container-fluid">
    <h2 class="m-4">Group Orders
        @can('create group orders')
        <a href="#"  @click="creating ? creating = false : creating = true"
            role="button" class="small" aria-label="Create new group order"
            data-toggle="tooltip" title="Create new group order">
            <i v-if="creating" class="fa fa-minus-square" aria-hidden="true"></i>
            <i v-else class="fa fa-plus-square" aria-hidden="true" v-cloak></i>
        </a>
        @endcan
    </h2>

    <div v-if="creating" v-cloak class="mx-4">
        <new-group-order-view :sellers="{{ $sellers }}" inline-template
            v-on:creation-cancelled="creating = false"
            v-on:creation-success="addGroupOrder">

            <div class="card">
                <h6 class="card-header">Create new group order</h6>
                <div class="card-body">
                    <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
                        <div class="form-group">
                            <label for="open-date">Open Date</label>
                            <input class="date form-control" :class="errors.open_date ? 'is-invalid' : ''"
                                id="open-date" type="date" name="open-date" v-model="form.open_date"> 
                            <form-error v-if="errors.open_date" :errors="errors">
                                @{{ errors.open_date[0] }}
                            </form-error>
                        </div>

                        <div class="form-group">
                            <label for="close-date">Close Date</label>
                            <input class="date form-control" :class="errors.close_date ? 'is-invalid' : ''"
                                id="close-date" type="date" name="close-date" v-model="form.close_date">

                            <form-error v-if="errors.close_date" :errors="errors">
                                @{{ errors.close_date[0] }}
                            </form-error>
                        </div>

                        <div class="form-group">
                            <label for="active-sellers">Active Sellers</label>

                            <div class="form-check" :class="errors.active_sellers ? 'is-invalid' : ''"
                                id="active-sellers" name="active-sellers" v-for="seller in sellers" v-bind:key="seller.id">

                                <input class="form-check-input" :class="errors.active_sellers ? 'is-invalid' : ''"
                                    type="checkbox" :value="seller.id" :name="`seller-${seller.id}`"  v-model="form.active_sellers">

                                <label class="form-check-label" :for="`seller-${seller.id}`">
                                    @{{seller.name}}
                                </label>

                                <template v-if="errors.active_sellers">
                                    <form-error :errors="errors">
                                        @{{ errors.active_sellers[0] }}
                                    </form-error>
                                </template>
                                <template v-else>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-secondary" @click="cancelCreation" v-scroll-to="'#app'">Cancel</button>
                    <button class="btn btn-primary" @click="postAddNewGroupOrder">Submit</button>
                </div>
            </div>
        </new-group-order-view>
    </div>

    <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4" v-for="(item, index) in items" v-bind:key="item.id" >
            <group-order-listing-item :group_order="item" class="m-4" v-on:updated-order="updateGroupOrder"></group-order-listing-item>
        </div>
    </div>
</div>
</group-order-listing-view>
@endsection