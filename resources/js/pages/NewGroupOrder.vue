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
                return moment(date).format('YYYY MM DD');
            }
        },

        created() {
            this.resetForm();
        },

        methods: {
            addGroupOrder() {

            },

            postAddNewGroupOrder() {
                return axios.post(this.uri, this.form).then( (response) =>  {
                    this.resetForm();
                    this.submitted = true;
                }).catch( (error) => {
                    this.errors = error.response.data.errors;
                });
            },

            resetForm() {
                this.form.open_date = moment().format('YYYY-MM-DD');
                this.form.close_date = moment().add(3, 'days').format('YYYY-MM-DD');
                this.errors = [];
                this.form.active_sellers = [];
            },

            moment: function () {
                return moment();
            }
        }
    }
</script>
