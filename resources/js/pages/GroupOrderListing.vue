<script>
    import GroupOrderListingItem from '../components/GroupOrderListingItem.vue';
    import collection from '../mixins/collection';

    export default {
        props: ['group_orders'],

        components: {
            GroupOrderListingItem
        },
        
        mixins: [collection],

        data() {
            return {
                items: this.group_orders,
                creating: false,
                created: false,
            };
        },

        computed: {
        },

        created() {
            this.created = false;
        },

        methods: {
            addGroupOrder(order) {
                this.created = true;
                this.creating = false;
                this.items.splice(0, 0, order);

                flash('Group order created')
            },

            updateGroupOrder(index, data) {
                this.items.splice(index, 1, data);
            },
        }
    }
</script>
