<template>
    <div class="card">
        <h5 class="card-header">创建</h5>
        <div class="card-body">
            <el-form ref="form" :model="form">
                <el-form-item label="用户名" labelWidth="100px">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="密码" labelWidth="100px">
                    <el-input type="password" v-model="form.password"></el-input>
                </el-form-item>
                <el-form-item labelWidth="100px">
                    <el-button type="primary" @click="doReturn">返回</el-button>
                    <el-button type="success" @click="doSubmit">提交</el-button>
                </el-form-item>
            </el-form>
        </div>
    </div>
</template>

<script>
    export default {
        name: "create",
        data: function () {
            return {
                apiCreate: api.adminAdminCreate,
                routeIndex: 'adminIndex',
                form: {},
            }
        },
        computed: {},
        methods: {
            doReturn: function () {
                this.$router.push({name: this.routeIndex});
            },
            doSubmit: function () {
                let self = this;
                axios.post(self.apiCreate, self.form).then(function () {
                    self.$message.success('成功');
                    self.doReturn();
                });
            },
        }
    }
</script>

<style scoped>

</style>