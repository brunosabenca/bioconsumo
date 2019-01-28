<template>
<div class="row shopping-cart-item" :id="'item-' + id">
    <div class="col-12 col-sm-12 col-md-2 text-center">
            <img class="img-responsive" src="http://placehold.it/120x80" alt="preview" width="120" height="80">
    </div>
    <div class="col-12 text-sm-center col-sm-12 text-md-left col-md-6">
        <h4 class="product-name"><strong v-text="item.product.name"></strong></h4>
        <h5>
            <small v-text="item.product.description"></small>
        </h5>
    </div>
    <div class="col-12 col-sm-12 text-sm-center col-md-4 text-md-right row">
        <div class="col-3 col-sm-3 col-md-6 text-md-right" style="padding-top: 5px">
            <h6><strong><span v-text="item.product.price"></span>€ <span class="text-muted">x</span></strong></h6>
        </div>
        <div class="col-4 col-sm-4 col-md-4">
            <div class="quantity">
                <input type="button" value="+" class="plus" v-show="open" :disabled="! open" v-on:click="incrementQty">
                <input type="number" title="Qty" class="qty"
                        size="4" :disabled="! open" v-model.number="form.quantity" v-on:change="updateQty">
                <input type="button" value="-" class="minus" v-show="open" :disabled="! open" v-on:click="decrementQty">
            </div>
        </div>
        <div class="col-2 col-sm-2 col-md-2 text-right" v-show="open">
            <button type="button" class="btn btn-outline-danger btn-xs" v-on:click="destroy">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
</template>


<script>
    export default {
        props: ['item', 'open'],

        data() {
            return {
                id: this.item.id,
                quantity: this.item.quantity,
                form: {},
            };
        },

        created() {
            this.resetPayload();
        },

        methods: {
            updateQty() {
                let uri = `/cart/item/${this.id}`;
                axios.patch(uri, this.form).then(response => {
                    this.quantity = this.form.quantity;
                    flash(this.item.product.name + "'s quantity updated to " + this.quantity);
                }).catch(error => {
                    this.resetPayload();
                    console.log( error.message);
                })
            },

            destroy() {
                let uri = `/cart/item/${this.id}`;
                axios.delete(uri);
                this.$emit('deleted', this.id);
            },

            incrementQty() {
                this.form.quantity = this.quantity + 1;
                this.updateQty();
            },

            decrementQty() {
                if (this.quantity > 1) {
                    this.form.quantity = this.quantity - 1;
                    this.updateQty();
                }
            },

            resetPayload() {
                this.form = {
                    quantity: this.quantity,
                };
            }
        }
    }
</script>