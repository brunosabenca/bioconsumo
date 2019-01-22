<script>
    export default {
        props: ['order'],

        components: {},

        data() {
            return {
                id: this.order.id,
                open_date: this.order.open_date,
                close_date: this.order.close_date,
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

                    //flash('The order has been updated.');
                })
            },

            resetForm() {
                this.form = {
                    open_date: this.open_date,
                    close_date: this.close_date,
                };

                this.editing = false;
            }
        }
    }
</script>
