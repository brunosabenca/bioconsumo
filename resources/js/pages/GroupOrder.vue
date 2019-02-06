<script>
    import GroupOrderListingItem from '../components/GroupOrderListingItem.vue';
    var moment = require('moment');

    export default {
        props: ['group_order'],

        components: {
            GroupOrderListingItem
        },

        data() {
            return {
                id: this.group_order.id,
                open_date: this.group_order.open_date,
                close_date: this.group_order.close_date,
                cancelled: this.group_order.cancelled,
                is_active: this.group_order.is_active,
                date_format: 'YYYY-MM-DD',
                form: {},
                editing: false
            };
        },

        created() {
            this.resetForm();
        },

        computed: {
            date: function (date) {
                return moment(date).format(this.date_format);
            }
        },

        methods: {
            update() {
                let uri = `/orders/${this.id}`;

                axios.patch(uri, this.form).then(() => {
                    this.editing = false;

                    this.open_date = this.form.open_date;
                    this.close_date = this.form.close_date;

                    flash('The order has been updated.');
                }).catch(error => {
                    console.log(error.message);
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
