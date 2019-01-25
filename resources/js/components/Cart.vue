<template>
   <div class="card shopping-cart">
            <div class="card-header bg-dark text-light">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                Products
                <a href="/products" class="btn btn-outline-info btn-sm pull-right" v-if="open">Continue adding products</a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                    <div class="row" v-for="item in items" v-bind:item="item" v-bind:key="item.id">
                        <div class="col-12 col-sm-12 col-md-2 text-center">
                                <img class="img-responsive" src="http://placehold.it/120x80" alt="preview" width="120" height="80">
                        </div>
                        <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
                            <h4 class="product-name"><strong v-text="item.product.name"></strong></h4>
                            <h4>
                                <small v-text="item.product.description"></small>
                            </h4>
                        </div>
                        <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
                            <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
                                <h6><strong><span v-text="item.product.price"></span>€ <span class="text-muted">x</span></strong></h6>
                            </div>
                            <div class="col-4 col-sm-4 col-md-4">
                                <div class="quantity">
                                    <input type="button" value="+" class="plus" v-show="open" :disabled="! open">
                                    <input type="number" step="1" max="99" min="1" value="1" title="Qty" class="qty"
                                           size="4" :disabled="! open">
                                    <input type="button" value="-" class="minus" v-show="open" disabled = "! open">
                                </div>
                            </div>
                            <div class="col-2 col-sm-2 col-md-2 text-right" v-show="open">
                                <button type="button" class="btn btn-outline-danger btn-xs">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </div>
                        </div>
                        <hr>
                    </div>
                    <div class="pull-right bottom-buttons">
                        <a href="" class="btn btn-outline-secondary pull-right" v-if="open">
                            Update
                        </a>
                    </div>
            </div>
        </div>

</template>

<script>
    export default {
        props: ['items', 'open'],

        components: {},

        data() {
            return {
            };
        },

        created() {
        }
    }
</script>
