<template>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">{{title}}</div>

            <div class="card-body">
                <p v-if="items.length === 0">Nothing to show</p>
                <ul class="list-group" v-if="items.length != 0">
                    <li class="list-group-item" v-for="message in items">
                        <router-link :to="{name: 'viewAnnouncement', params: {id: message.id}}">
                            {{message.subject}}
                        </router-link>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "DashboardCardComponent",
        props: ['items', 'title']
    }
</script>

<style scoped>

</style>
