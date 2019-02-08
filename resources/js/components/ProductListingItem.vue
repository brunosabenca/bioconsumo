<template>
<!-- Editing -->
<div>
    <div class="card product-card-editing" :id="`product-${product.id}-editing`" v-show="editing">
        <img class="card-img-top img-responsive" :src="imagePath">
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
        </div>

        <div class="card-footer d-flex flex-row align-items-center">
            <button class="btn btn-danger btn-sm" v-show="authorize('owns', product) || authorize('can', 'delete any product')"
                @click="destroy" aria-label="Delete" data-toggle="tooltip" title="Delete this product">
                <i class="fa fa-trash" aria-hidden="true"></i>
            </button>
            <button class="btn btn-secondary btn-sm ml-a mr-1" @click="resetForm"
                data-toggle="tooltip" title="Cancel changes"
                v-scroll-to="{el: `#product-${product.id}-editing`, offset: -90}">
                <i class="fa fa-times-circle" aria-hidden="true"></i> Cancel
            </button>
            <button class="btn btn-primary btn-sm" @click="update"
                data-toggle="tooltip" title="Save changes"
                v-scroll-to="{el: `#product-${product.id}`, offset: -90}">
                <i class="fa fa-save" aria-hidden="true"></i> Save
            </button>
        </div>
    </div>
    <!-- Viewing -->
    <div class="card product-card" :id="`product-${product.id}`" v-show="! editing">
        <img class="card-img-top img-responsive" :src="imagePath">
        <div class="card-header product-card-header ">
            <a class="card-link" v-show="! single" :href="`/products/${product.id}`"></a>
            <div class="d-flex align-items-center">
                <p class="ml-2 flex-grow-1">
                    <span v-if="seller"><span v-text="seller"></span>'s</span>
                    <span v-text="product.name" class="product-name"></span>
                </p>
                <p class="product-price">
                    <span v-text="price"></span>
                    <span class="ml-1 small">/ <span v-text="stock_unit_type"></span></span>
                </p>
            </div>
        </div>

        <div class="card-body">
            <p class="card-text"><span v-text="description"></span></p>
            <p class="card-text">Stock: <span v-text="stock"></span></p>
        </div>

        <div class="card-footer d-flex flex-row align-items-center">
            <div class="flex-grow-1 ml-1">
                <button class="flex-grow-1 btn btn-secondary btn-sm" v-show="authorize('owns', product) || authorize('can','edit any product')"
                    @click="editing = true"
                    data-toggle="tooltip" title="Edit this product"
                    v-scroll-to="{el: `#product-${product.id}`, offset: -90}">
                        <i class="fa fa-edit" aria-hidden="true"></i> Edit
                </button>
            </div>

            <div class="flex-grow-0 ml-a">
                <div class="input-group add-to-cart" v-show="stock > 0 && authorize('can','add items to cart')">
                    <vue-numeric
                        class="form-control"
                        value="0"
                        :currency="unit_symbol"
                        currency-symbol-position="suffix"
                        :minus="false"
                        :precision="unit_precision"
                        :empty-value="0"
                        v-bind:min="0"
                        v-bind:max="10000"
                        v-model.number="form.quantity"
                        data-toggle="tooltip"
                        title="Quantity"></vue-numeric>
                    <div class="input-group-append">
                        <button class="btn btn-primary" @click="addToCart" aria-label="Add product to order" data-toggle="tooltip" title="Add product to your order">
                            <i class="fa fa-cart-plus" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
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

        data() {
            return {
                id: this.product.id,
                name: this.product.name,
                seller: this.product.seller.name,
                description: this.product.description,
                price: this.product.price,
                stock: this.product.stock,
                stock_unit_type: this.product.stock_unit_type,
                quantity: 0,
                path: '/products/' + this.product.id,
                imagePath: '/images/products/' + this.product.id + '.jpg',
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
            },

            has_stock() {
                return (this.product.stock > 0 ? true : false);
            },

            unit_precision() {
                return (this.stock_unit_type == 'Kg' || this.stock_unit_type == 'g' ? 2 : 0);
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
                        flash(`${this.form.quantity} ${this.stock_unit_type} of ${this.name} added to your order`);
                    }).catch( (error) => {
                        flash(error.response.data.message, 'danger');
                    });
                } else {
                    flash('Please input a valid quantity', 'warning');
                }


            }, 

            destroy() {
                axios.delete(this.path).then(() => {
                    this.$emit('deleted', this.id);
                    flash(`${this.name} deleted`, 'success');
                }).catch((error) => {
                    flash("The product couldn't be deleted", 'danger');
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

                    flash('The product has been updated');
                }).catch((error) => {
                    flash("The product couldn't be updated", 'danger');
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