<template>
    <div class="container">
        <div class="row justify-content-center">
            <dashboard-card-component title="New Announcements" v-bind:items="newAnnouncements"></dashboard-card-component>
            <dashboard-card-component title="Recently Updated Announcements" v-bind:items="recentlyUpdatedAnnouncements"></dashboard-card-component>
        </div>
        <div class="row justify-content-center">
            <dashboard-card-component title="Next Announcements" v-bind:items="nextAnnouncements"></dashboard-card-component>
            <dashboard-card-component title="Expired Announcements" v-bind:items="expiredAnnouncements"></dashboard-card-component>
        </div>
    </div>
</template>

<script>
    import DashboardCardComponent from "./DashboardCardComponent";
    export default {
        name: "DashboardComponent",
        components: {DashboardCardComponent},
        mounted() {
            this.fetchExpired();
            this.fetchNew();
            this.fetchNext();
            this.fetchUpdated();
        },
        data() {
            return {
                newAnnouncements: [],
                recentlyUpdatedAnnouncements: [],
                expiredAnnouncements: [],
                nextAnnouncements: [],
            }
        },
        methods: {
            fetchNew() {
                this.$http.get('/messages/new')
                    .then(resp => {
                        this.newAnnouncements = resp.data;
                    }).catch(err => (console.error(err)));
            },
            fetchUpdated() {
                this.$http.get('/messages/updated')
                    .then(resp => {
                        this.recentlyUpdatedAnnouncements = resp.data;
                    }).catch(err => (console.error(err)));
            },
            fetchExpired() {
                this.$http.get('/messages/expired')
                    .then(resp => {
                        this.expiredAnnouncements = resp.data;
                    }).catch(err => (console.error(err)));
            },
            fetchNext() {
                this.$http.get('/messages/next')
                    .then(resp => {
                        this.nextAnnouncements = resp.data;
                    }).catch(err => (console.error(err)));
            },
        }
    }
</script>

<style scoped>
.row {
    margin-top: 5px;
    margin-bottom: 5px;
}
</style>
