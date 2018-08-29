<template>
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="javascript:" @click="go('index')">管理后台</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="javascript:" @click="go('infoIndex')">资料管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:" @click="go('userIndex')">用户管理</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="javascript:" @click="go('adminIndex')">管理员管理</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item dropdown ml-md-auto">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                       data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        个人中心
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="javascript:" @click="doLogout">退出</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
    export default {
        name: "my-nav",
        data: function () {
            return {
                collapseIn: false
            };
        },
        computed: {
            user: function () {
                return this.$store.state.user;
            },
        },
        mounted: function () {
            $('.navbar-collapse').on('click', '.collapse-hide', function () {
                $('.navbar-collapse').collapse('hide');
            });
        },
        methods: {
            doLogout: function () {
                let self = this;
                axios.get(api.adminIndexLogout).then(function () {
                    self.$router.push('/login');
                });
            },
            go: function (name) {
                this.$router.push({name: name});
            },
        }
    };
</script>

<style scoped>
    .navbar {
        max-height: 100%;
    }
</style>