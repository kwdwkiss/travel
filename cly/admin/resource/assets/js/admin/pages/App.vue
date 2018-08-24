<template>
    <div>
        <my-nav></my-nav>

        <div class="container-fluid" style="padding-top:55px">

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
    .el-pagination {
        float: right;
    }

    .el-row {
        margin: 10px 0;
    }
</style>