<script>
    import ProductListingItem from '../components/ProductListingItem.vue';
    import collection from '../mixins/collection';

    export default {
        props: ['products'],

        components: {ProductListingItem},

        mixins: [collection],

        computed: {
            chunkedProducts () {
                return _.chunk(this.products,3)
            }
        },


        data() {
            return {
                items: this.products
            };
        },

        created() {
        },

        methods: {

        }
    }
</script>
