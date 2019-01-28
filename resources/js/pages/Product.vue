<script>
    export default {
        props: ['product'],

        components: {},

        data() {
            return {
                name: this.product.name,
                description: this.product.description,
                price: this.product.price,
                form: {},
                editing: false
            };
        },

        created() {
            this.resetForm();
        },

        methods: {
            update() {
                let uri = `/products/${this.product.id}`;

                axios.patch(uri, this.form).then(() => {
                    this.editing = false;
                    this.name = this.form.name;
                    this.description = this.form.description;
                    this.price = this.form.price;

                    flash('The product has been updated.');
                })
            },

            resetForm() {
                this.form = {
                    name: this.product.name,
                    description: this.product.description,
                    price: this.product.price
                };

                this.editing = false;
            }
        }
    }
</script>
