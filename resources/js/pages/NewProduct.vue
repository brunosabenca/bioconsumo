<script>
    var moment = require('moment');
    import FormError from '../components/FormError.vue';

    export default {
        props: ['sellers'],

        components: {FormError},

        data() {
            return {
                uri: '/products',
                submitted: false,
                form: {
                },
                errors: []
            };
        },

        filters: {
            date: function (date) {
                return moment(date).format('YYYY-MM-DD');
            }
        },

        created() {
            this.resetForm();
        },

        methods: {
            addProduct() {

            },

            postAddNewProduct() {
                return axios.post(this.uri, this.form).then( (response) =>  {
                    this.resetForm();
                    this.submitted = true;
                }).catch( (error) => {
                    // Error
                    if (error.response) {
                        this.submitted = false;
                        this.errors = error.response.data.errors;
                    } else if (error.request) {
                        console.log(error.request);
                    } else {
                        console.log('Error', error.message);
                    }
                });
            },

            resetForm() {
                 this.form.name = "";
                this.form.description = "";
                this.form.price = "";
                this.form.stock = "";
                this.form.user_id = this.sellers[0].id;
                this.submitted = false;
                this.errors = [];
            },

            moment: function () {
                return moment();
            }
        }
    }
</script>
