<template>
    <div class="card">
        <h5 class="card-header">登录</h5>
        <div class="card-body">
            <form class="form-horizontal">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">手机号</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" v-model="form.mobile">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">密码</label>
                    <div class="col-md-7">
                        <input type="password" class="form-control" v-model="form.password">
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7 offset-md-3">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" v-model="form.remember"> 记住我
                            </label>
                            &nbsp;
                            <a href="javascript:" @click="forgetPassword">忘记密码</a>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7 offset-md-3">
                        <button type="button" class="btn btn-primary" @click="doLogin">登录</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Login",
        data: function () {
            return {
                form: {
                    remember: true
                }
            }
        },
        methods: {
            doLogin: function () {
                let self = this;
                axios.post(api.indexIndexLogin, self.form).then(function () {
                    self.$message.success('登录成功');
                    self.$store.commit('user', {
                        callback: function () {
                            self.$router.push('/');
                        }
                    })
                });
            },
            forgetPassword: function () {
                this.$router.push({name: 'forget_password'});
            }
        }
    }
</script>

<style scoped>

</style>