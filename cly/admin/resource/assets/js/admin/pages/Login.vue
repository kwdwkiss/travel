<template>
    <div class="d-flex align-items-center" style="position:fixed;top:0;bottom:0;width:100%">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">登录</div>
                        <div class="card-body">
                            <form method="POST" aria-label="Login">
                                <div class="form-group row py-2">
                                    <label for="email" class="col-sm-4 col-form-label text-md-right">
                                        用户名</label>
                                    <div class="col-md-7">
                                        <input id="email" required="required" autofocus="autofocus"
                                               class="form-control" v-model="form.username">
                                    </div>
                                </div>
                                <div class="form-group row py-2">
                                    <label for="password" class="col-md-4 col-form-label text-md-right">
                                        密码</label>
                                    <div class="col-md-7">
                                        <input id="password" type="password" required="required"
                                               class="form-control" v-model="form.password">
                                    </div>
                                </div>
                                <div class="form-group row mb-0 py-2">
                                    <div class="col-md-8 offset-md-4">
                                        <button type="button" class="btn btn-primary" @click="doLogin">
                                            登录
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data: function () {
            return {
                form: {}
            }
        },
        methods: {
            doLogin: function () {
                let self = this;
                axios.post(api.adminIndexLogin, self.form).then(function () {
                    self.$store.commit('user', {
                        callback: function () {
                            self.$router.push('/');
                        }
                    });
                });
            }
        }
    }
</script>

<style scoped>

</style>