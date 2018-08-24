<template>
    <div class="card">
        <h5 class="card-header">注册</h5>
        <div class="card-body">
            <form class="form-horizontal">
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">手机号</label>
                    <div class="col-md-7">
                        <input type="text" class="form-control" placeholder="请输入手机号"
                               v-model="form.mobile">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">密码</label>
                    <div class="col-md-7">
                        <input type="password" class="form-control"
                               placeholder="密码必须包含字母、数字、符号两种组合且长度为8-16"
                               v-model="form.password">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-md-3 col-form-label text-md-right">短信验证码</label>
                    <div class="col-md-5">
                        <input class="form-control" placeholder="请输入短信验证码" v-model="form.code">
                    </div>
                    <span class="col-md-2">
                        <my-sms :mobile="form.mobile" :action="'register'"></my-sms>
                    </span>
                </div>
                <div class="form-group">
                    <div class="col-md-7 offset-md-3">
                        <label>
                            <input type="checkbox" v-model="form.remember"> 记住我
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-7 offset-md-3">
                        <button type="button" class="btn btn-primary" @click="doRegister">注册</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "Register",
        data: function () {
            return {
                form: {
                    remember: true
                }
            }
        },
        methods: {
            doRegister: function () {
                let self = this;
                axios.post(api.indexUserRegister, self.form).then(function () {
                    self.$store.commit('user', {
                        callback: function () {
                            self.$router.push({name: 'index'})
                        }
                    })
                })
            }
        }
    }
</script>

<style scoped>

</style>