<template>
<div class="card" v-if="editing">
    <div class="card-body">
        <input type="text" class="card-title" v-model="name" maxlength="80"/>
        <br/>
        <textarea class="card-text" v-model="description"  maxlength="255"></textarea>
        <br/>
        <div class="level">
            <input type="text" class="card-title mr-1" v-model="price"  maxlength="4"/>
            <span> per <span v-text="stock_unit_type"></span></span>
        </div>
        <button class="btn btn-secondary btn-sm" @click="editing = true" v-show="! editing">Edit</button>
        <br/>
        <div class="level">
            <button class="btn btn-secondary btn-sm ml-a mr-1" @click="resetForm">Cancel</button>
            <button class="btn btn-primary btn-sm" @click="update">Update</button>
        </div>
    </div>
</div>
<div class="card" v-else>
    <div class="card-body">
        <h5 class="card-title level">
            <span class="text-muted" v-if="seller"><span v-text="seller"></span>'s</span>
            <span class="ml-1" v-text="name"></span>
            <span class="ml-a">
                <span v-text="price"></span>€
                <span class="ml-1 small"> / <span v-text="stock_unit_type"></span></span>
            </span>
        </h5>
        <p class="card-text"><span v-text="description"></span></p>
        <p class="card-text">Stock: <span v-text="stock"></span></p>
        <button class="btn btn-secondary btn-sm" @click="editing = true">Edit</button>
        <button class="btn btn-danger btn-sm ml-1" @click="destroy">Delete</button>

        <div class="pull-right">
            <div class="quantity">
                 <vue-numeric
                    v-clear-zero
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

    export default {
        props: ['product'],

        components: {
            VueNumeric
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
                editing: false
            };
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
                    flash(`${this.name} deleted`, 'danger');
                });
                this.$emit('deleted', this.id);
            }, 

            update() {
                let uri = `/products/${this.product.id}`;

                axios.patch(uri, this.form).then(() => {
                    this.editing = false;
                    this.name = this.form.name;
                    this.description = this.form.description;
                    this.price = this.form.price;

                    flash('The product has been updated.');
                })
            },

            resetForm() {
                this.form = {
                    name: this.product.name,
                    description: this.product.description,
                    price: this.product.price,
                    quantity: this.quantity
                };

                this.editing = false;
            }

        }

    }
</script>