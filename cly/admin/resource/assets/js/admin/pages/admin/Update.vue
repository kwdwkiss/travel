<template>
    <div class="card">
        <h5 class="card-header">更新</h5>
        <div class="card-body">
            <el-form ref="form" :model="form">
                <el-form-item label="用户名" labelWidth="100px">
                    <label>{{form.name}}</label>
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
        name: "update",
        data: function () {
            return {
                apiDetail: api.adminAdminDetail,
                apiUpdate: api.adminAdminUpdate,
                routeIndex: 'adminIndex',
                form: {},
            }
        },
        computed: {},
        mounted: function () {
            this.loadData();
        },
        methods: {
            loadData: function () {
                let self = this;
                let id = self.$route.params.id;
                axios.get(self.apiDetail, {params: {id: id}}).then(function (res) {
                    self.form = res.data.data;
                });
            },
            doReturn: function () {
                this.$router.push({name: this.routeIndex});
            },
            doSubmit: function () {
                let self = this;
                axios.post(self.apiUpdate, self.form).then(function () {
                    self.$message.success('成功');
                    self.doReturn();
                });
            },
        }
    }
</script>

<style scoped>

</style>