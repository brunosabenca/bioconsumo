<template>
   <div class="card shopping-cart">
            <div class="card-header bg-dark text-light">
                <i class="fa fa-shopping-cart" aria-hidden="true"></i>
                Products
                <a href="/products" class="btn btn-outline-info btn-sm pull-right" v-if="is_active">Continue adding products</a>
                <div class="clearfix"></div>
            </div>
            <div class="card-body">
                    <div v-for="(item, index) in items" :key="item.id">
                        <cart-item :item="item" :is_active="is_active" v-on:deleted="remove(index)"></cart-item>
                    </div>
            </div>
        </div>

</template>

<script>
    import CartItem from './CartItem.vue';
    import collection from '../mixins/collection';

    export default {
        components: {CartItem},

        props: ['cartitems', 'is_active'],

        mixins: [collection],

        data() {
            return {
                items: this.cartitems,
            };
        },

        created() {
        },

        methods: {
            updateQty() {

            }
        }
    }
</script>
