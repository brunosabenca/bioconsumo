<template>
<div class="d-flex flex-column mb-3">
    <div class="card flex-grow-0">
        <h5 class="card-header">Order of <span v-text="shortDate(this.open_date)"></span>
            <div v-cloak>
                <span class="badge badge-danger text-uppercase" v-show="cancelled">Cancelled</span>
                <span class="badge badge-success text-uppercase" v-show="is_active">Open</span>
                <span class="badge badge-secondary text-uppercase" v-show="! is_active && ! cancelled">Closed</span>
            </div>
        </h5>
        <div class="card-body d-flex flex-row">
            <div class="flex-grow-0" style="flex-basis: 15em;">

                <h6 v-if="! cancelled && is_active"><span class="text-uppercase small"><strong>closing <span v-text="fromNow(this.close_date)"></span>
                    </strong></span></h6>

                <h6 v-if="! cancelled && ! is_active"><span class="text-uppercase small"><strong>opening <span v-text="fromNow(this.open_date)"></span>
                    </strong></span></h6>
            </div>

            <div class="ml-2">
                <h6>Active Sellers:</h6>
                <ul>
                    <li v-for="seller in group_order.sellers" v-text="seller.name" v-bind:key="seller.id"></li>
                </ul>
            </div>
        </div>

        <div class="flex-grow-0 list-group list-group-flush" v-if="editing">
            <div class="d-flex flex-row list-group-item">
                <div class="form-group">
                    <label for="open-date">Open Date</label>
                    <input class="date form-control"  v-model="form.open_date" id="open-date" type="date" name="open-date">
                </div>
                <div class="form-group ml-2">
                    <label for="close-date">Close Date</label>
                    <input class="date form-control" v-model="form.close_date"  id="close-date" type="date" name="close-date">
                </div>
            </div>
        </div>

        <div class="card-footer d-flex flex-row" v-if="! cancelled && authorize('can', 'edit group orders')">
            <div class="level">
                <button type="submit" class="btn btn-danger btn-sm" aria-label="Delete" @click="destroy">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
                <button class="btn btn-primary btn-sm ml-1" v-if="! editing" @click="editing = true">Edit</button>
                <button class="btn btn-secondary btn-sm ml-1" v-else @click="resetForm">Cancel</button>
                <button class="btn btn-primary btn-sm ml-1" v-if="editing" @click="update">Save</button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
    var moment = require('moment');

    export default {
        props: {
            group_order: {
                required: true
            },
            single: {
              type: Boolean,
              default: false
            }
        },

        components: {
        },

        data() {
            return {
                id: this.group_order.id,
                open_date: this.group_order.open_date,
                close_date: this.group_order.close_date,
                cancelled: this.group_order.cancelled,
                is_active: this.group_order.is_active,
                date_format: 'YYYY-MM-DD',
                short_date_format: 'MMM D, YYYY',
                path: '/orders/' + this.group_order.id,
                form: {},
                editing: false
            }
        },

        computed: {
        },

        created() {
            this.resetForm();
        },

        methods: {
            update() {
                axios.patch(this.path, this.form).then((response) => {
                    this.editing = false;

                    this.open_date = this.form.open_date;
                    this.close_date = this.form.close_date;

                    this.$emit('order-updated', response);

                    this.is_active = response.is_active;

                    flash('The order has been updated.');
                }).catch(error => {
                    console.log(error.message);
                })
            },

            destroy() {
                axios.delete(this.path).then((response) => {
                    this.cancelled = true;
                    this.is_active = false;
                    
                    this.$emit('order-updated', response);

                    flash('The order has been cancelled.', 'success');
                }).catch((error) => {
                    flash("The order couldn't be cancelled.", 'danger');
                });
            }, 


            fromNow (date) {
                return moment(date).fromNow();
            },

            date(date) {
                return moment(date).format(this.date_format);
            },

            shortDate(date) {
                return moment(date).format(this.short_date_format);
            },

            resetForm() {
                this.form = {
                    open_date: this.group_order.open_date,
                    close_date: this.group_order.close_date,
                };

                this.editing = false;
            }

        }

    }
</script>