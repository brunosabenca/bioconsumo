<script>
    export default {
        props: ['order'],

        components: {},

        data() {
            return {
                id: this.order.id,
                open_date: this.order.open_date,
                close_date: this.order.close_date,
                cancelled: this.order.cancelled,
                open: this.order.open,
                form: {},
                editing: false
            };
        },

        created() {
            this.resetForm();
        },

        methods: {
            update() {
                let uri = `/orders/${this.id}`;

                axios.patch(uri, this.form).then(() => {
                    this.editing = false;

                    this.open_date = this.form.open_date;
                    this.close_date = this.form.close_date;
                    this.open = this.form.open;

                    //flash('The order has been updated.');
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
                    open_date: this.open_date,
                    close_date: this.close_date,
                    open: this.open,
                };

                this.editing = false;
            }
        }
    }
</script>
