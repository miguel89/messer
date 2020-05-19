<template>
    <welcome-component v-if="!$auth.check()"></welcome-component>
    <dashboard-component v-else></dashboard-component>
</template>

<script>
    import WelcomeComponent from "./WelcomeComponent";
    import DashboardComponent from "./DashboardComponent";
    export default {
        components: {DashboardComponent, WelcomeComponent},
        mounted() {

        }
    }
</script>
<style scoped>

</style>
