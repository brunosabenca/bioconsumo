<template>
<!-- Editing -->
<div class="card" v-if="editing">
    <div class="card-body">
        <div class="form-group">
            <div class="form-row">
                <label for="name">Name</label>
                <input type="text" class="card-title form-control" id="name" v-model="form.name" maxlength="80"/>
            </div>
        </div>

        <div class="form-group">
            <div class="form-row">
                <label for="description">Description</label>
                <textarea class="card-text form-control" id="description" v-model="form.description" maxlength="255" rows="4"></textarea>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <div class="form-col">
                    <label for="stock">Stock</label>
                    <input type="text" class="card-title form-control" v-model="form.stock"  maxlength="4"/>
                </div>
            </div>
            <div class="form-group ml-a">
                <div class="form-col">
                    <label for="price">Price / <span v-text="stock_unit_type"></span></label>
                    <money class="form-control" v-model="form.price" v-bind="money"></money>
                </div>
            </div>
        </div>

        <button class="btn btn-secondary btn-sm" @click="editing = true" v-show="! editing">Edit</button>
        <br/>
        <div class="level">
            <button class="btn btn-secondary btn-sm ml-a mr-1" @click="resetForm">Cancel</button>
            <button class="btn btn-primary btn-sm" @click="update">Update</button>
        </div>
    </div>
</div>
<!-- Viewing -->
<div class="card" v-else>
    <div class="card-body">
        <h5 class="card-title level">
            <span class="text-muted" v-if="seller"><span v-text="seller"></span>'s</span>
            <span class="ml-1" v-text="name" v-if="single"></span>
            <a class="ml-1" v-text="name" :href="`/products/${product.id}`" v-else></a>
            <span class="ml-a">
                <span v-text="price"></span>
                <span class="ml-1 small"> / <span v-text="stock_unit_type"></span></span>
            </span>
        </h5>
        <p class="card-text"><span v-text="description"></span></p>
        <p class="card-text">Stock: <span v-text="stock"></span></p>

        <button class="btn btn-secondary btn-sm" v-if="authorize('owns', product) || authorize('can','delete any product')" @click="editing = true">Edit</button>
        <button class="btn btn-danger btn-sm ml-1" v-if="authorize('owns', product) || authorize('can', 'edit any product')" @click="destroy">Delete</button>

        <div class="pull-right" v-if="stock > 0 && authorize('can','add item to cart')">
            <div class="quantity">
                 <vue-numeric
                    value="0"
                    class="qty"
                    :currency="unit_symbol"
                    currency-symbol-position="suffix"
                    :minus="false"
                    :precision="0"
                    :empty-value="0"
                    v-bind:min="0"
                    v-bind:max="10000"
                    v-model.number="form.quantity" ></vue-numeric>
            </div>
            <button class="btn btn-primary" @click="addToCart" aria-label="Add to Cart">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
</template>

<script>
    import VueNumeric from 'vue-numeric';
    import {Money} from 'v-money';

    export default {
        props: {
            product: {
                required: true
            },
            single: {
              type: Boolean,
              default: false
            }
        },

        components: {
            VueNumeric,
            Money
        },

        computed: {
            has_stock() {
                return (this.product.stock > 0 ? true : false);
            },
        },

        data() {
            return {
                id: this.product.id,
                name: this.product.name,
                seller: this.product.seller.name,
                description: this.product.description,
                price: this.product.price,
                stock: this.product.stock,
                stock_unit: this.product.stock_unit,
                stock_unit_type: this.product.stock_unit_type,
                quantity: 0,
                path: '/products/' + this.product.id,
                form: {},
                editing: false,
                money: {
                    decimal: ',',
                    thousands: '.',
                    prefix: '€',
                    suffix: '',
                    precision: 2,
                    masked: false
                }
            }
        },


        computed: {
            unit_symbol: function() {
                if (this.stock_unit_type == 'Kg' || this.stock_unit_type == 'g') {
                    return this.stock_unit_type;
                } else {
                    return '';
                }
            }
        },

        created() {
            this.resetForm();
        },

        methods: {
            addToCart() {
                let uri = `/cart/add/${this.id}`;

                if (this.form.quantity >= 1) {
                    axios.post(uri, this.form).then(() => {
                        flash(`${this.form.quantity} ${this.stock_unit_type} of ${this.name} added to the cart`);
                    });
                } else {
                        flash('Please input a valid quantity', 'danger');
                }


            }, 

            destroy() {
                axios.delete(this.path).then(() => {
                    this.$emit('deleted', this.id);
                    flash(`${this.name} deleted`, 'success');
                }).catch((error) => {
                    flash("The product couldn't be deleted.", 'danger');
                });
            }, 

            update() {
                let uri = `/products/${this.product.id}`;

                axios.patch(uri, this.form).then(() => {
                    this.editing = false;
                    this.name = this.form.name;
                    this.description = this.form.description;
                    this.price = '€' + this.form.price;
                    this.stock = this.form.stock;

                    flash('The product has been updated.');
                }).catch((error) => {
                    flash("The product couldn't be updated.", 'danger');
                });
            },

            resetForm() {
                this.form = {
                    name: this.product.name,
                    description: this.product.description,
                    price: this.product.price,
                    quantity: this.quantity,
                    stock: this.stock
                };

                this.editing = false;
            }

        }

    }
</script>