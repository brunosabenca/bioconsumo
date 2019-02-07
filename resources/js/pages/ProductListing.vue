<script>
    import ProductListingItem from '../components/ProductListingItem.vue';
    import collection from '../mixins/collection';

    export default {
        props: ['products', 'sellers'],

        components: {
            ProductListingItem
        },

        mixins: [collection],

        data() {
            return {
                items: this.products,
                results: [],
                keys: ['name', 'description'],
                seller_id: null,
                creating: false,
                created: false,
            };
        },

        computed: {
            filteredChunks : function () {
                return _.chunk(this.filteredItems(this.items, this.seller_id), 3)
            }
        },

        created() {
            this.$on('results', results => {
                this.results = results
            })
        },

        methods: {
            addProduct(product) {
                this.created = true;
                this.creating = false;
                this.items.splice(0, 0, product);

                flash('Product created.')
            },

            updateProduct(index, data) {
                this.items.splice(index, 1, data);
            },

            removeProduct(product) {
                let index = this.items.indexOf(product)
                this.remove(index);
            },

            filteredItems (items, seller_id) {
                if (seller_id != null){
                    return this.results.filter(function (item) {
                        return item.seller.id === seller_id;
                    });
                } else {
                    return this.results;
                }
            },

            setItems(items) {
                this.items = items;
            }
        }
    }
</script>
