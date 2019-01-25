<script>
    import Cart from '../components/Cart.vue';

    export default {
        props: ['user_order'],

        components: {Cart},

        data() {
            return {
                id: this.user_order.id,
                isOpen: this.user_order.open,
                cancelled: this.user_order.cancelled,
                delivered: this.user_order.delivered,
                form: {},
                editing: false
            };
        },

        created() {
            this.resetForm();
        },

        methods: {
            update() {
                let uri = `/user/orders/${this.id}`;

                axios.patch(uri, this.form).then(() => {
                    this.editing = false;

                    this.isOpen = this.form.open;

                    flash('The order has been updated.');
                }).catch(error => {
                    console.log(error.message);
                })
            },

            close() {
                this.form.open = false;
                this.update();
            },

            open() {
                this.form.open = true;
                this.update();
            },

            cancel() {
                let uri = `/user/orders/${this.id}`;

                axios.delete(uri).then(() => {
                    this.cancelled = true;
                    this.isOpen = false;

                    flash('The order has been cancelled.', 'danger');
                }).catch(error => {
                    console.log(error.message);
                })
            },

            resetForm() {
                this.form = {
                    open: this.isOpen,
                };

                this.editing = false;
            }
        }
    }
</script>
