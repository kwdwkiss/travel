<template>
    <div>
        <my-nav></my-nav>

        <div class="container" style="padding-top:55px">

            <router-view></router-view>

        </div>
    </div>
</template>
<script>
    export default {
        name: 'app'
    }
</script>
<style>
    @media (min-width: 1200px) {
        .container {
            max-width: 960px;
        }
    }
</style>