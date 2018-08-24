<template>
    <div>

    </div>
</template>

<script>
    export default {
        name: "Index",
        mounted: function () {
            axios.get(api.adminIndexInfo).then(function () {

            });
        }
    }
</script>

<style scoped>

</style>