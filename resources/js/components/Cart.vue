<template>
   <div class="card shopping-cart">
        <div class="card-header bg-dark text-light d-flex justify-content-between">
            <span><i class="fa fa-shopping-cart" aria-hidden="true"></i> Products</span>
            <a href="/products" class="btn btn-outline-info btn-sm pull-right" v-if="is_active">Continue adding products</a>
        </div>

        <div class="card-body">
            <div class="d-flex flex-column">
                <cart-item v-for="(item, index) in items" :key="item.id" :item="item" :is_active="is_active" v-on:updated="updateTotal()" v-on:deleted="remove(index)"></cart-item>
            </div>
        </div>

        <div class="card-footer">
            <div class="d-flex flex-row-reverse">
                <h4><strong><span v-text="total"></span></strong></h4>
            </div>
        </div>
    </div>
</template>

<script>
    import CartItem from './CartItem.vue';
    import collection from '../mixins/collection';

    export default {
        components: {CartItem},

        props: ['user_order_id', 'cartitems', 'is_active'],

        mixins: [collection],

        data() {
            return {
                items: this.cartitems,
                total: '',
            };
        },

        created() {
            this.updateTotal();
        },

        methods: {
            sumPrices(items) {
                let total = 0;
                _.forEach(items, function (item) {
                    total += +item.price;
                })
                return total;
            }, 

            updateTotal() {
                //this.total = '€' + this.sumPrices(this.items).toFixed(2);
                let uri = `/user/orders/${this.user_order_id}/price`;
                axios.get(uri).then(response => {
                    this.total = response.data;
                }).catch(error => {
                    console.log(error.message);
                })
            },

            remove(index) {
                this.items.splice(index, 1);
                this.updateTotal();
                this.$emit('removed');
            }
        }
    }
</script>
