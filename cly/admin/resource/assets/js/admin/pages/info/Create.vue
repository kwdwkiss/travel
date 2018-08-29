<template>
    <div class="card">
        <h5 class="card-header">创建</h5>
        <div class="card-body">
            <el-form ref="form" :model="form">
                <el-form-item label="类型" labelWidth="100px">
                    <el-select v-model="form.type" placeholder="请选择类型">
                        <el-option v-for="item in taxonomy.info_type"
                                   :key="item.id"
                                   :label="item.label"
                                   :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="名称" labelWidth="100px">
                    <el-input v-model="form.name"></el-input>
                </el-form-item>
                <el-form-item label="地址" labelWidth="100px">
                    <el-input v-model="form.address"></el-input>
                </el-form-item>
                <el-form-item label="电话" labelWidth="100px">
                    <el-input v-model="form.phone"></el-input>
                </el-form-item>
                <el-form-item label="备注" labelWidth="100px">
                    <el-input v-model="form.remark"></el-input>
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
                apiCreate: api.adminInfoCreate,
                routeIndex: 'infoIndex',
                form: {},
            }
        },
        computed: {
            taxonomy: function () {
                return this.$store.state.taxonomy;
            }
        },
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