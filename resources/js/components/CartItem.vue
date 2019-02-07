<template>
<div class="d-flex flex-row flex-wrap flex-md-nowrap shopping-cart-item flex-grow-0 flex-shrink-0 mt-2" :id="'item-' + id">
    <div class="flex-column flex-shrink-0 flex-grow-0 p-2">
            <img class="img-responsive" src="http://placehold.it/120x80" alt="preview" width="120" height="80">
    </div>

    <div class="flex-column flex-shrink-1 flex-grow-0 p-2" style="flex-basis: 60em;">
        <h4 class="product-name"><strong v-text="item.product.name"></strong></h4>
        <h5>
            <small v-text="item.product.description"></small>
        </h5>
    </div>

    <div class="d-flex justify-content-end flex-fill">
        <div class="flex-column align-self-center flex-shrink-0 flex-grow-0 px-1 pt-2">
            <h6><strong><span v-text="formattedPrice"></span></strong></h6>
        </div>
        <div class="flex-column align-self-center flex-grow-0 flex-shrink-0 px-1">
            <div class="quantity">
                <input type="button" value="+" class="plus" v-show="is_active" :disabled="! is_active" v-on:click="incrementQty"
                    aria-label="Increment quantity" data-toggle="tooltip" title="Increment quantity">
                <input type="number" class="qty"
                        size="4" :disabled="! is_active" v-model.number="form.quantity" v-on:change="updateQty"
                        aria-label="Quantity" data-toggle="tooltip" title="Quantity">
                <input type="button" value="-" class="minus" v-show="is_active" :disabled="! is_active" v-on:click="decrementQty"
                    aria-label="Decrement quantity" data-toggle="tooltip" title="Decrement quantity">
            </div>
        </div>

        <div class="unit flex-column align-self-center flex-grow-0 flex-shrink-0 pt-2 text-left">
            <h6><strong><span class="text-muted">x</span></strong> <span v-text="unit" class="big"></span></h6>
        </div>

        <div class="flex-column align-self-center flex-grow-0 flex-shrink-0 px-1 " v-show="is_active">
            <button role="button" type="button" class="btn btn-outline-danger btn-xs" v-on:click="destroy"
                aria-label="Remove item from cart" data-toggle="tooltip" title="Remove item from cart">
                <i class="fa fa-trash" aria-hidden="true" ></i>
            </button>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['item', 'is_active'],

        data() {
            return {
                id: this.item.id,
                quantity: this.item.quantity,
                unit: this.item.product.stock_unit_type,
                price: this.item.price,
                form: {},
            };
        },

        created() {
            this.resetPayload();
        },

        computed: {
            formattedPrice : function () {
                return '€' + this.price;
            },

            last() {
                return Object.keys(this.person).length-1;
            }
        },

        methods: {
            updateQty() {
                let uri = `/cart/item/${this.id}`;
                axios.patch(uri, this.form).then(response => {
                    this.quantity = this.form.quantity;
                    flash(this.item.product.name + "'s quantity updated to " + this.quantity);
                    this.item.price = response.data;
                    this.price = this.item.price;
                    this.$emit('updated');
                }).catch(error => {
                    this.resetPayload();
                    console.log( error.message);
                })
            },

            destroy() {
                let uri = `/cart/item/${this.id}`;
                axios.delete(uri);
                this.$emit('deleted', this.id);
                flash(this.item.product.name + ' removed from your order');
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