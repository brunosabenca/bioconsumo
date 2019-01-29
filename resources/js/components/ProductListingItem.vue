<template>
<div class="card" v-if="editing">
    <div class="card-body">
        <input type="text" class="card-title" v-model="name" maxlength="80"/>
        <br/>
        <textarea class="card-text" v-model="description"  maxlength="255"></textarea>
        <br/>
        <div class="level">
            <input type="text" class="card-title mr-1" v-model="price"  maxlength="4"/>
            <span>€/Kg</span>
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
            <span v-text="name"></span>
            <span class="ml-a"><span v-text="price"></span>€/Kg</span>
        </h5>
        <p class="card-text"><span v-text="description"></span></p>
        <button class="btn btn-secondary btn-sm" @click="editing = true">Edit</button>
        <button class="btn btn-danger btn-sm ml-1" @click="deleteProduct">Delete</button>

        <div class="pull-right">
            <div class="quantity">
                <input type="number" title="Qty" class="qty"
                        size="4" v-model.number="form.quantity">
            </div>
            <button class="btn btn-primary" @click="addToCart" aria-label="Add to Cart">
                <i class="fa fa-cart-plus" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        props: ['product'],

        data() {
            return {
                id: this.product.id,
                name: this.product.name,
                description: this.product.description,
                price: this.product.price,
                quantity: 1,
                path: '/products/' + this.product.id,
                form: {},
                editing: false
            };
        },

        computed: {
        },

        created() {
            this.resetForm();
        },

        methods: {
            addToCart() {
                let uri = `/cart/add/${this.id}`;

                axios.post(uri, this.form).then(() => {
                    flash(`${this.name} (${this.form.quantity}) added to the cart`);
                });

            }, 

            deleteProduct() {

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