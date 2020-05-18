<template>
    <div class="form-div">
        <div class="alert alert-danger" v-if="has_error && !success">
            <p v-if="error == 'registration_validation_error'">Validations Errors.</p>
            <p v-else>Error. It is not possible to complete the operation at the moment.</p>
        </div>
        <div class="col-md-4">
            <h3>Instructions</h3>
            <p>
                Lorem ipsum TODO
            </p>
        </div>
        <div class="col-md-8">
            <form autocomplete="off" @submit.prevent="save" v-if="!success" method="post">

                <div class="form-group row" v-bind:class="{ 'has-error': has_error && errors.subject }">
                    <label for="subject">Subject</label>

                    <input id="subject" type="text" class="form-control" name="subject"
                           v-model="subject" required autocomplete="subject" autofocus>

                    <span class="help-block" v-if="has_error && errors.subject">{{ errors.subject[0] }}</span>

                </div>

                <div class="form-group row" v-bind:class="{ 'has-error': has_error && errors.content }">
                    <label for="content">Content</label>


                    <textarea id="content" class="form-control" name="content"
                              v-model="content" required autocomplete="content"></textarea>

                    <span class="help-block" v-if="has_error && errors.content">{{ errors.content[0] }}</span>
                </div>

                <div class="row">
                <div class="form-group col-md-6" v-bind:class="{ 'has-error': has_error && errors.start_date }">
                    <label for="start_date">Start date</label>

                    <datepicker id="start_date" name="start_date" v-model="start_date"></datepicker>

                    <span class="help-block" v-if="has_error && errors.start_date">{{ errors.start_date[0] }}</span>
                </div>

                <div class="form-group col-md-6" v-bind:class="{ 'has-error': has_error && errors.expiration_date }">
                    <label for="expiration_date">Expiration date</label>

                    <datepicker id="expiration_date" name="expiration_date" v-model="expiration_date"></datepicker>

                    <span class="help-block"
                          v-if="has_error && errors.expiration_date">{{ errors.expiration_date[0] }}</span>
                </div>
                </div>


                <div class="form-group row mb-0">
                    <div class="ml-auto">
                        <button type="submit" class="btn btn-primary">
                            {{action}}
                        </button>
                        <button type="button" class="btn btn-danger">
                            Cancel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import Datepicker from 'vuejs-datepicker';
    export default {
        name: "MessageFormComponent",
        data() {
            return {
                subject: '',
                content: '',
                start_date: '',
                expiration_date: '',
                has_error: false,
                error: '',
                errors: {},
                success: false,
                loading: false
            }
        },
        components: {
            Datepicker
        },
        props:['action'],
        methods: {
            save() {
                this.loading = true;
                this.$http.post('/messages', {
                    subject: this.subject,
                    content: this.content,
                    start_date: this.start_date,
                    expiration_date: this.expiration_date,
                }).then(resp => {
                    this.loading = false;
                    this.success = true;
                }).catch(resp => {
                    this.success = false;
                    console.log(resp);
                    console.log(resp.errors);
                    this.errors = resp.response.data.errors;
                    this.error = resp.message;
                    this.has_error = true;
                    this.loading = false;
                });
            }
        }
    }
</script>

<style scoped>
.form-div {
    display: flex;
}
</style>
