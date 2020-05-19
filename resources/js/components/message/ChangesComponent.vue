<template>
    <div class="row justify-content-center changes-div">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Changes</div>

                <div class="card-body">
                    <p v-if="items.length === 0">Nothing to show</p>
                    <table class="table" v-if="items.length != 0">
                        <thead>
                        <tr>
                            <th scope="col">Date</th>
                            <th scope="col">Description</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="change in items">
                            <td>{{change.created_at | formatFullDate}}</td>
                            <td>{{change.description}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    export default {
        name: "ChangesComponent",
        data() {
            return {
                items: []
            }
        },
        props: ['messageId'],
        mounted() {
            this.list();
        },
        methods: {
            list() {
                this.$http.get(`/messages/${this.messageId}/changes`)
                    .then(resp => {
                        this.items = resp.data;
                    }).catch(err => (console.error(err)));
            }
        }
    }
</script>

<style scoped>
.changes-div {
    margin-top: 10px;
}
</style>
