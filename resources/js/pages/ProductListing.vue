<script>
    import ProductListingItem from '../components/ProductListingItem.vue';
    import collection from '../mixins/collection';

    export default {
        props: ['products'],

        components: {ProductListingItem},

        mixins: [collection],

        data() {
            return {
                items: this.products,
            };
        },

        computed: {
            chunks () {
                return _.chunk(this.items,3)
            }
        },

        created() {
        },

        methods: {
            removeProduct(product) {
                let index = this.items.indexOf(product)
                this.remove(index);
            }
        }
    }
</script>
