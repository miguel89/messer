<template>
    <div>
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="/">
                    Messer
                </a>

                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item" v-if="$auth.check()" >
                            <router-link :to="{ name: 'listAnnouncements' }" class="nav-link">Announcements</router-link>
                        </li>
                        <li class="nav-item" v-if="$auth.check()" >
                            <router-link :to="{ name: 'createAnnouncement' }" class="nav-link">Create Announcement</router-link>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->

                        <li class="nav-item" v-if="!$auth.check()" >
                            <router-link :to="{ name: 'login' }" class="nav-link">Login</router-link>
                        </li>

                        <li class="nav-item" v-if="!$auth.check()">
                            <router-link :to="{ name: 'register' }" class="nav-link">Register</router-link>
                        </li>

                        <li class="nav-item" v-if="$auth.check()">
                            <a class="nav-link" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                {{ $auth.user().name }}  <span class="caret"></span>
                            </a>
                        </li>
                        <li class="nav-item" v-if="$auth.check()">
                            <a class="nav-link" href="#" @click.prevent="$auth.logout()">
                                Logout
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
    export default {
        name: 'AppComponent',
    data() {
        return {
            routes: {
                unlogged: [
                    {
                        name: 'Register',
                        path: 'register'
                    },
                    {
                        name: 'Login',
                        path: 'login'
                    }
                ],
                // LOGGED USER
                user: [
                    {
                        name: 'Dashboard',
                        path: 'dashboard'
                    }
                ]
            }
        }
    },
    mounted() {
        //
    }
}
</script>

<style scoped>

</style>
