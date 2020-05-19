<template>
    <div class="form-div">
        <div class="alert alert-danger" v-if="has_error && !success">
            <p v-if="error == 'registration_validation_error'">Validations Errors.</p>
            <p v-else>Error. It is not possible to complete the operation at the moment.</p>
        </div>
        <div class="col-md-4">
            <h3>Instructions</h3>
            <p>
                Fill out the form with the subject, content, start and expiration dates.
            </p>
        </div>
        <div class="col-md-8">
            <form autocomplete="off" @submit.prevent="submit" method="post">

                <div class="form-group row" v-bind:class="{ 'has-error': has_error && errors.subject }">
                    <label for="subject">Subject</label>

                    <input id="subject" type="text" class="form-control" name="subject" v-bind:disabled="view"
                           v-model="subject" required autocomplete="subject" autofocus>

                    <span class="help-block" v-if="has_error && errors.subject">{{ errors.subject[0] }}</span>

                </div>

                <div class="form-group row" v-bind:class="{ 'has-error': has_error && errors.content }">
                    <label for="content">Content</label>


                    <textarea id="content" class="form-control" name="content" v-bind:disabled="view"
                              v-model="content" required autocomplete="content"></textarea>

                    <span class="help-block" v-if="has_error && errors.content">{{ errors.content[0] }}</span>
                </div>

                <div class="row">
                <div class="form-group col-md-6" v-bind:class="{ 'has-error': has_error && errors.start_date }">
                    <label for="start_date">Start date</label>

                    <datepicker id="start_date" name="start_date"  v-bind:disabled="view"
                                v-model="start_date"></datepicker>

                    <span class="help-block" v-if="has_error && errors.start_date">{{ errors.start_date[0] }}</span>
                </div>

                <div class="form-group col-md-6" v-bind:class="{ 'has-error': has_error && errors.expiration_date }">
                    <label for="expiration_date">Expiration date</label>

                    <datepicker id="expiration_date" name="expiration_date" v-bind:disabled="view"
                                v-model="expiration_date"></datepicker>

                    <span class="help-block"
                          v-if="has_error && errors.expiration_date">{{ errors.expiration_date[0] }}</span>
                </div>
                </div>


                <div class="form-group row mb-0">
                    <div class="ml-auto">
                        <button type="submit" class="btn btn-primary" v-if="!view">
                            {{action}}
                        </button>
                        <router-link :to="{name: 'editAnnouncement', params: {id: this.dataId}}" v-if="view"
                                     class="btn btn-primary">Edit</router-link>
                        <router-link :to="{name: 'listAnnouncements'}" class="btn btn-danger">Cancel</router-link>
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
        props:['action', 'dataId', 'view'],
        methods: {
            submit() {
                if (this.dataId) {
                    this.update();
                } else {
                    this.save();
                }
            },
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
                    console.log(resp.data);
                    this.$router.push({name: 'viewAnnouncement', params: {id: resp.data.id}});
                }).catch(resp => {
                    this.success = false;
                    this.errors = resp.response.data.errors;
                    this.error = resp.message;
                    this.has_error = true;
                    this.loading = false;
                });
            },
            update() {
                this.loading = true;
                this.$http.put(`/messages/${this.dataId}`, {
                    subject: this.subject,
                    content: this.content,
                    start_date: this.start_date,
                    expiration_date: this.expiration_date,
                }).then(resp => {
                    this.loading = false;
                    this.success = true;
                    this.$router.push({name: 'viewAnnouncement', params: {dataId: resp.data.id}});
                }).catch(resp => {
                    this.success = false;
                    this.errors = resp.response.data.errors;
                    this.error = resp.message;
                    this.has_error = true;
                    this.loading = false;
                });
            }
        },
        mounted() {
            if (this.dataId) {
                this.$http.get(`/messages/${this.dataId}`).then(resp => {
                    this.loading = false;
                    this.success = true;
                    console.log(resp);
                    this.subject = resp.data.subject;
                    this.content = resp.data.content;
                    this.start_date = resp.data.start_date;
                    this.expiration_date = resp.data.expiration_date;
                }).catch(resp => {
                    console.error(resp);
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
