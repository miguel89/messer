<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Register</div>

                    <div class="card-body">
                        <div class="alert alert-danger" v-if="has_error && !success">
                            <p v-if="error == 'registration_validation_error'">Validations Errors.</p>
                            <p v-else>Error. It is not possible to complete the operation at the moment.</p>
                        </div>

                        <form autocomplete="off" @submit.prevent="register" v-if="!success" method="post">

                            <div class="form-group row" v-bind:class="{ 'has-error': has_error && errors.name }">
                                <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name"
                                           v-model="name" required autocomplete="name" autofocus>

                                    <span class="help-block" v-if="has_error && errors.name">{{ errors.name }}</span>
                                </div>
                            </div>

                            <div class="form-group row" v-bind:class="{ 'has-error': has_error && errors.email }">
                                <label for="email" class="col-md-4 col-form-label text-md-right">Email Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email"
                                           v-model="email" required autocomplete="email">

                                    <span class="help-block" v-if="has_error && errors.email">{{ errors.email }}</span>
                                </div>
                            </div>

                            <div class="form-group row" v-bind:class="{ 'has-error': has_error && errors.password }">
                                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" v-model="password"
                                           name="password" required autocomplete="new-password">

                                    <span class="help-block"
                                          v-if="has_error && errors.password">{{ errors.password }}</span>
                                </div>
                            </div>

                            <div class="form-group row" v-bind:class="{ 'has-error': has_error && errors.password }">
                                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm
                                    Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                           v-model="password_confirmation"
                                           name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        Register
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "RegisterComponent",
        data() {
            return {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                has_error: false,
                error: '',
                errors: {},
                success: false
            }
        },
        methods: {
            register() {
                const app = this;
                this.$auth.register({
                    data: {
                        name: app.name,
                        email: app.email,
                        password: app.password,
                        password_confirmation: app.password_confirmation
                    },
                    success: function () {
                        app.success = true;
                        this.$router.push({name: 'login', params: {successRegistrationRedirect: true}});
                    },
                    error: function (res) {
                        console.error(res.response.data.errors);
                        app.has_error = true;
                        app.error = res.response.data.error;
                        app.errors = res.response.data.errors || {};
                    }
                })
            }
        }
    }
</script>

<style scoped>

</style>
