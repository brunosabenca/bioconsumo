<script>
    export default {
        props: ['user_order'],

        components: {},

        data() {
            return {
                id: this.user_order.id,
                open: this.user_order.open,
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

                    this.open = this.form.open;

                    flash('The order has been updated.');
                }).catch(error => {
                    console.log(error.message);
                })
            },

            closeOrder() {
                this.form.open = false;
                this.update();
            },

            openOrder() {
                this.form.open = true;
                this.update();
            },

            resetForm() {
                this.form = {
                    open: this.open,
                };

                this.editing = false;
            }
        }
    }
</script>
