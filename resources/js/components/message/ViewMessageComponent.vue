<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">View Announcement</div>

                    <div class="card-body">
                        <message-form-component v-bind:view="true" v-bind:data-id="$route.params.id"></message-form-component>
                    </div>
                </div>
            </div>
        </div>
        <changes-component v-bind:message-id="$route.params.id"></changes-component>
    </div>
</template>

<script>
    import MessageFormComponent from "./MessageFormComponent";
    import ChangesComponent from "./ChangesComponent";
    export default {
        name: "CreateMessageComponent",
        components: {MessageFormComponent, ChangesComponent}
    }
</script>

<style scoped>

</style>
