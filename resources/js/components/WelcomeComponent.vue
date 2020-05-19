<template>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                Messer
            </div>
            <p>
                Login ou create an account to continue
            </p>
        </div>
    </div>
</template>

<script>
    export default {
        name: "WelcomeComponent"
    }
</script>

<style scoped>
    html, body {
        background-color: #fff;
        color: #636b6f;
        font-family: 'Nunito', sans-serif;
        font-weight: 200;
        height: 100vh;
        margin: 0;
    }
    .full-height {
        height: 100vh;
    }

    .flex-center {
        align-items: center;
        display: flex;
        justify-content: center;
    }

    .position-ref {
        position: relative;
    }
    .content {
        text-align: center;
    }

    .title {
        font-size: 84px;
    }
    .m-b-md {
        margin-bottom: 30px;
    }
    p {
        color: #636b6f;
        padding: 0 25px;
        font-size: 13px;
        font-weight: 600;
        letter-spacing: .1rem;
        text-decoration: none;
        text-transform: uppercase;
    }
</style>
