<template>
<div class="d-flex flex-column">
    <div class="card flex-grow-0">
        <h5 class="d-flex card-header">
            <div class="flex-grow-1">
                <a :href="path">Order of <span v-text="shortDate(this.open_date)"></span></a>
                <div v-cloak>
                    <span class="badge badge-danger text-uppercase" v-show="cancelled">Cancelled</span>
                    <span class="badge badge-success text-uppercase" v-show="is_active">Open</span>
                    <span class="badge badge-secondary text-uppercase" v-show="! is_active && ! cancelled">Closed</span>
                </div>
            </div>
            <span class="small" v-show="! cancelled && is_active"><span class="text-uppercase small"><strong>closing <span v-text="fromNow(this.close_date)"></span></strong></span></span>
            <span class="small" v-show="! cancelled && ! is_active"><span class="text-uppercase small"><strong>opening <span v-text="fromNow(this.open_date)"></span></strong></span></span>
        </h5>

        <div class="px-4 py-4">
            <h6>Active Sellers</h6>
            <ul class="list-group">
                <li class="list-group-item" v-for="seller in group_order.sellers" v-bind:key="seller.id">
                    <img :src="avatarPath(seller.id)" class="rounded-circle z-depth-0" alt="avatar image" height="35">
                    <span v-text="seller.name"></span>
                </li>
            </ul>
        </div>

        <div class="flex-grow-0 list-group list-group-flush" v-show="editing">
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

        <div class="card-footer d-flex flex-row" v-if="authorize('can', 'edit group orders')">
                <button class="btn btn-primary btn-sm ml-1" v-show="! editing && ! cancelled" @click="editing = true"
                    data-toggle="tooltip" title="Edit group order">
                    <i class="fa fa-edit" aria-hidden="true"></i>
                    Edit
                </button>

                <button type="submit" class="btn btn-danger btn-sm" aria-label="Delete" v-show="editing" @click="destroy"
                    data-toggle="tooltip" title="Cancel group order">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </button>

                <button class="btn btn-secondary btn-sm ml-a" aria-label="Cancel" v-show="editing" @click="resetForm"
                    data-toggle="tooltip" title="Cancel changes">
                    <i class="fa fa-times-circle" aria-hidden="true"></i>
                    Cancel
                </button>

                <button class="btn btn-primary btn-sm ml-1" aria-label="Save" v-show="editing" @click="update"
                    data-toggle="tooltip" title="Save changes">
                    <i class="fa fa-save" aria-hidden="true"></i>
                    Save
                </button>
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

                    this.$emit('order-updated', response.data);

                    this.is_active = response.data.is_active;

                    flash('The order has been updated');
                }).catch(error => {
                    console.log(error.message);
                })
            },

            destroy() {
                axios.delete(this.path).then((response) => {
                    this.cancelled = true;
                    this.is_active = false;
                    this.editing = false;
                    
                    this.$emit('order-updated', response);

                    flash('The order has been cancelled', 'success');
                }).catch((error) => {
                    flash("There was a problem cancelling the order", 'danger');
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
            },

            avatarPath(id) {
                return `/storage/avatars/user-${id}.png`;
            }

        }

    }
</script>