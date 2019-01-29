<script>
    import Cart from '../components/Cart.vue';

    export default {
        props: ['user_order'],

        components: {Cart},

        data() {
            return {
                id: this.user_order.id,
                cancelled: this.user_order.cancelled,
                delivered: this.user_order.delivered,
                is_active: this.user_order.is_active,
                editing: false
            };
        },

        created() {
        },

        methods: {
        }
    }
</script>
