<script>
    import ProductListingItem from '../components/ProductListingItem.vue';
    import collection from '../mixins/collection';

    export default {
        props: ['products', 'sellers'],

        components: {ProductListingItem},

        mixins: [collection],

        data() {
            return {
                items: this.products,
                seller_id: null
            };
        },

        computed: {
            filteredChunks : function () {
                return _.chunk(this.filteredItems(this.items, this.seller_id), 3)
            }
        },

        created() {
        },

        methods: {
            removeProduct(product) {
                let index = this.items.indexOf(product)
                this.remove(index);
            },

            filteredItems (items, seller_id) {
                if (seller_id != null){
                    return this.items.filter(function (item) {
                        return item.seller.id === seller_id;
                    });
                } else {
                    return this.items;
                }
            }
        }
    }
</script>
