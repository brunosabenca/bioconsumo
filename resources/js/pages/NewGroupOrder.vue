<script>
    var moment = require('moment');
    import FormError from '../components/FormError.vue';

    export default {
        props: ['sellers'],

        components: {FormError},

        data() {
            return {
                uri: '/orders',
                submitted: false,
                form: {
                    open_date: '',
                    close_date: '',
                    active_sellers: []
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
            addGroupOrder() {

            },

            postAddNewGroupOrder() {
                var searchUrl = this.uri
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
                this.submitted = false;
                this.errors = [];
                this.form.open_date = moment().format('YYYY-MM-DD');
                this.form.close_date = moment().add(3, 'days').format('YYYY-MM-DD');
                this.form.active_sellers = [];
            },

            moment: function () {
                return moment();
            }
        }
    }
</script>
