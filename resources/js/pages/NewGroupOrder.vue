<template>
<div class="container-fluid">
    <h4>Create new group order</h4>
    <div class="row">
        <div class="col-sm-6 col-md-4 col-xl-3 mb-3">
            <div class="alert alert-success" v-if="submitted" v-cloak>
                Group order successfully created!
            </div>
            <div class="form-group">
                <label for="open-date">Open Date</label>
                <input class="date form-control" :class="errors.open_date ? 'is-invalid' : ''" id="open-date" type="date" name="open-date" v-model="form.open_date"> 
                <form-error v-if="errors.open_date" :errors="errors">
                    <span v-text="errors.open_date[0]"></span>
                </form-error>
            </div>

            <div class="form-group">
                <label for="close-date">Close Date</label>
                <input class="date form-control" :class="errors.close_date ? 'is-invalid' : ''" id="close-date" type="date" name="close-date" v-model="form.close_date">
                <form-error v-if="errors.close_date" :errors="errors">
                    {{ errors.close_date[0] }}
                </form-error>
            </div>

            <div class="form-group">
                <label for="active-sellers">Active Sellers</label>

                <div class="form-check" :class="errors.active_sellers ? 'is-invalid' : ''" id="active-sellers" name="active-sellers" v-for="seller in sellers" v-bind:key="seller.id">
                    <input class="form-check-input" :class="errors.active_sellers ? 'is-invalid' : ''" type="checkbox" :value="seller.id" :name="`seller-${seller.id}`"  v-model="form.active_sellers">
                    <label class="form-check-label" :for="`seller-${seller.id}`">
                        {{seller.name}}
                    </label>

                    <template v-if="errors.active_sellers">
                        <form-error :errors="errors">
                            {{ errors.active_sellers[0] }}
                        </form-error>
                    </template>
                    <template v-else>
                    </template>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary" @click="postAddNewGroupOrder">Submit</button>
            </div>
        </div>
    </div>
</div>
</template>
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
                form: {},
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
            cancelCreation() {
                this.$emit('creation-cancelled');
            },

            postAddNewGroupOrder() {
                return axios.post(this.uri, this.form).then( (response) =>  {
                    this.$emit('creation-success', response.data);

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
