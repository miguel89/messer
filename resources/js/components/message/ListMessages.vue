<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Announcements</div>

                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">Expiration Date</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="message in items">
                                <th scope="row">{{message.id}}</th>
                                <td>{{message.subject}}</td>
                                <td>{{message.start_date | formatDate}}</td>
                                <td>{{message.expiration_date | formatDate}}</td>
                                <td>
                                    <router-link :to="{name: 'viewAnnouncement', params: {id: message.id}}" class="btn btn-sm btn-default">View</router-link>
                                    <router-link :to="{name: 'editAnnouncement', params: {id: message.id}}" class="btn btn-sm btn-default">Edit</router-link>
                                    <button type="button" class="btn btn-sm btn-danger">Delete</button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <nav class="pagination-nav" aria-label="Navigation">
                            <ul class="pagination">
                                <li class="page-item" v-bind:class="{disabled: previousPage == null}">
                                    <button type="button" class="page-link"
                                       v-on:click="list(currentPage - 1)">Previous</button>
                                </li>
                                <li class="page-item" v-for="pageIndex in pageCount"
                                    v-bind:class="{disabled: pageIndex === currentPage}">
                                    <button type="button" class="page-link"
                                            v-on:click="list(pageIndex)">{{pageIndex}}</button>
                                </li>
                                <li class="page-item" v-bind:class="{disabled: nextPage == null}">
                                    <button type="button" class="page-link"
                                                 v-on:click="list(currentPage + 1)">Next</button>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "ListMessages",
        data() {
            return {
                items: [],
                currentPage: 1,
                pageCount: 1,
                previousPage: null,
                nextPage: null,
            }
        },
        mounted() {
            this.list();
        },
        methods: {
            list(page = 1) {
                this.$http.get(`/messages?page=${page}`)
                    .then(resp => {
                        this.items = resp.data.data;
                        this.pageCount = resp.data.last_page;
                        this.previousPage = resp.data.prev_page_url;
                        this.nextPage = resp.data.next_page_url;
                        this.currentPage = resp.data.current_page;
                    }).catch(err => (console.error(err)));
            }
        }
    }
</script>

<style scoped>
.pagination-nav {
    text-align: center;
}
.pagination {
    display: inline-flex;
}
</style>
